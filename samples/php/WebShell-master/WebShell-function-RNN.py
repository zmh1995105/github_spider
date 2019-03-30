import re
import os
import numpy as np
import tflearn
from sklearn.model_selection import train_test_split
from tflearn.data_utils import to_categorical, pad_sequences
from sklearn import metrics
from sklearn.metrics import classification_report

max_sequences_len = 300
max_sys_call = 0

def load_line(filename):
    global max_sys_call
    x = []
    with open(filename) as f:
        line = f.readline()
        line = line.strip('\n')
        line = line.split(' ')
        for i in line:
            if len(i) > 0:
                x.append(int(i))
                if int(i) > max_sys_call:
                    max_sys_call = int(i)
    return x

def load_trainning_data(datadir):
    x = []
    y = []
    list = os.listdir(datadir)
    for i in range(0, len(list)):
        path = os.path.join(datadir, list[i])
        if os.path.isfile(path):
            x.append(load_line(path))
            y.append(0)
    return x, y

def dirlist(path, allfile):
    filelist = os.listdir(path)
    for filename in filelist:
        filepath = os.path.join(path, filename)
        if os.path.isdir(filepath):
            dirlist(filepath, allfile)
        else:
            allfile.append(filepath)
    return allfile

def load_webshell_data(datadir):
    x = []
    y = []
    allfile = dirlist(datadir, [])
    for file in allfile:
        if re.match(r"Data1/ADFA-LD/Web_Shell_\d+/UAD-W*", file):
            x.append(load_line(file))
            y.append(1)
    return x, y

def run_rnn(x_train, x_test, y_train, y_test):
    global max_sequences_len
    global max_sys_call

    x_train = pad_sequences(x_train, maxlen = max_sequences_len, value = 0.)
    x_test = pad_sequences(x_test, maxlen = max_sequences_len, value = 0.)
    y_train = to_categorical(y_train, nb_classes = 2)
    y_test_old = y_test
    y_test = to_categorical(y_test, nb_classes = 2)

    print "SET max_sequences_len: %d" % max_sequences_len
    print "SET max_sys_call: %d" % max_sys_call

    net = tflearn.input_data([None, max_sequences_len])
    net = tflearn.embedding(net, input_dim = max_sys_call + 1, output_dim = 128)
    net = tflearn.lstm(net, 128, dropout = 0.8)
    net = tflearn.fully_connected(net, 2, activation = 'softmax')
    net = tflearn.regression(net, optimizer = 'adam', learning_rate = 0.1, loss = 'categorical_crossentropy')

    model = tflearn.DNN(net, tensorboard_verbose = 3)
    model.fit(x_train, y_train, validation_set = (x_test, y_test), show_metric = True, batch_size = 32, run_id = "Han")

    y_predict_list = model.predict(x_test)
    #print y_predict_list

    y_predict = []

    for i in y_predict_list:
        print i[0]
        if i[0] > 0.8:
            y_predict.append(0)
        else:
            y_predict.append(1)

    #y_predict=to_categorical(y_predict, nb_classes=2)

    print (classification_report(y_test_old, y_predict))
    print metrics.confusion_matrix(y_test_old, y_predict)
    print metrics.recall_score(y_test_old, y_predict)
    print metrics.accuracy_score(y_test_old, y_predict)

if __name__ == '__main__':

    x1, y1 = load_trainning_data("Data1/ADFA-LD/Training_Data_Master/")
    x2, y2 = load_webshell_data("Data1/ADFA-LD/Attack_Data_Master/")
    x = x1 + x2
    y = y1 + y2
    x_train, x_test, y_train, y_test = train_test_split(x, y, test_size = 0.5, random_state = 0)
    run_rnn(x_train, x_test, y_train, y_test)