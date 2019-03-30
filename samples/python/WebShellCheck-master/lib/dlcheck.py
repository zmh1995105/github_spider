from keras.models import Model, model_from_json, Sequential
from keras.layers import Input, SpatialDropout1D, GlobalMaxPool1D
from keras.layers import Dense
from keras.layers import Flatten
from keras.layers import Dropout
from keras.layers import Embedding
from keras.layers.convolutional import Conv1D
from keras.layers.convolutional import MaxPooling1D
from keras.layers.merge import concatenate
from keras.callbacks import ModelCheckpoint
from keras.utils.vis_utils import plot_model
import numpy as np
import os
import matplotlib.pyplot as plt
import nltk
from keras.preprocessing.sequence import pad_sequences
from keras.utils import np_utils
from sklearn.model_selection import train_test_split
import subprocess
import re
import random
import string


def word_tokenize(line):
    return nltk.word_tokenize(line)

class Opcode:
    def __init__(self, file_path):
        self.file_path = file_path
        self.op_list = self.get_opcode(file_path)
        self.op_str = ' '.join(self.op_list)
        self.legit = True
        if len(self.op_list) < 3:
            self.legit = False
            self.errmsg = 'not php file or echo only'

    def get_opcode(self, file_path):
        cmd = "php -dvld.active=1 -dvld.execute=0 " + file_path
        output = subprocess.getstatusoutput(cmd)[1]
        return re.findall(r'\s(\b[A-Z_]{2,})\s', output)



class WordVecCnn(object):
    model_name = 'wordvec_cnn'

    def __init__(self):
        self.model = None
        self.word2idx = None
        self.idx2word = None
        self.max_len = None
        self.config = None
        self.vocab_size = None
        self.labels = None

    @staticmethod
    def get_weight_file_path(model_dir_path):
        return model_dir_path + '/' + WordVecCnn.model_name + '_weights.h5'

    @staticmethod
    def get_config_file_path(model_dir_path):
        return model_dir_path + '/' + WordVecCnn.model_name + '_config.npy'

    @staticmethod
    def get_architecture_file_path(model_dir_path):
        return model_dir_path + '/' + WordVecCnn.model_name + '_architecture.json'

    def load_model(self, model_dir_path):
        json = open(self.get_architecture_file_path(model_dir_path), 'r').read()
        self.model = model_from_json(json)
        self.model.load_weights(self.get_weight_file_path(model_dir_path))
        self.model.compile(optimizer='adam', loss='categorical_crossentropy', metrics=['accuracy'])

        config_file_path = self.get_config_file_path(model_dir_path)

        self.config = np.load(config_file_path).item()

        self.idx2word = self.config['idx2word']
        self.word2idx = self.config['word2idx']
        self.max_len = self.config['max_len']
        self.vocab_size = self.config['vocab_size']
        self.labels = self.config['labels']



    def predict(self, sentence):
        xs = []
        tokens = [w.lower() for w in word_tokenize(sentence)]
        wid = [self.word2idx[token] if token in self.word2idx else len(self.word2idx) for token in tokens]
        xs.append(wid)
        x = pad_sequences(xs, self.max_len)
        output = self.model.predict(x)
        return output[0]

    def predict_class(self, sentence):
        predicted = self.predict(sentence)
        idx2label = dict([(idx, label) for label, idx in self.labels.items()])
        return idx2label[np.argmax(predicted)]

class WordVecLstmSigmoid(object):
    model_name = 'lstm_sigmoid'

    def __init__(self):
        self.model = None
        self.word2idx = None
        self.idx2word = None
        self.max_len = None
        self.config = None
        self.vocab_size = None
        self.labels = None

    @staticmethod
    def get_architecture_file_path(model_dir_path):
        return model_dir_path + '/' + WordVecLstmSigmoid.model_name + '_architecture.json'

    @staticmethod
    def get_weight_file_path(model_dir_path):
        return model_dir_path + '/' + WordVecLstmSigmoid.model_name + '_weights.h5'

    @staticmethod
    def get_config_file_path(model_dir_path):
        return model_dir_path + '/' + WordVecLstmSigmoid.model_name + '_config.npy'

    def load_model(self, model_dir_path):
        json = open(self.get_architecture_file_path(model_dir_path), 'r').read()
        self.model = model_from_json(json)
        self.model.load_weights(self.get_weight_file_path(model_dir_path))
        self.model.compile(optimizer='adam', loss='categorical_crossentropy', metrics=['accuracy'])

        config_file_path = self.get_config_file_path(model_dir_path)

        self.config = np.load(config_file_path).item()

        self.idx2word = self.config['idx2word']
        self.word2idx = self.config['word2idx']
        self.max_len = self.config['max_len']
        self.vocab_size = self.config['vocab_size']
        self.labels = self.config['labels']

    def predict(self, sentence):
        xs = []
        tokens = [w.lower() for w in word_tokenize(sentence)]
        wid = [self.word2idx[token] if token in self.word2idx else 1 for token in tokens]
        xs.append(wid)
        x = pad_sequences(xs, self.max_len)
        output = self.model.predict(x)[0]
        return [1-output[0], output[0]]

    def predict_class(self, sentence):
        predicted = self.predict(sentence)
        idx2label = dict([(idx, label) for label, idx in self.labels.items()])
        return idx2label[np.argmax(predicted)]


def allcheck(code):
    randstr = ''.join([random.choice(string.ascii_lowercase) for _ in range(16)])
    filepath = '/tmp/'+randstr+'shell'+'.php'
    print(filepath)
    open(filepath,'w').write(code)
    ops = Opcode(filepath).op_str
    model_dir_path = './models'
    cnnclassifier = WordVecCnn()
    cnnclassifier.load_model(model_dir_path=model_dir_path)
    cnn_label = cnnclassifier.predict_class(ops)
    print(cnn_label)
    if cnn_label == '1':
        return 'N'
    else:
        return 'M'
    #print(cnn_label)
    #lstmclassifier = WordVecLstmSigmoid()
    #lstmclassifier.load_model(model_dir_path=model_dir_path)
    #lstm_label = lstmclassifier.predict_class(ops)
    #print(lstm_label)
