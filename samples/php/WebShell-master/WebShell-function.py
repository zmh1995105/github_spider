import os
import re
import numpy as np
from sklearn import neighbors
from sklearn.feature_extraction.text import CountVectorizer
from sklearn.model_selection import cross_val_score
from sklearn.neural_network import MLPClassifier

def load_line(filename):
    with open(filename) as f:
        line = f.readline()
        line = line.strip('\n')
    return line

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

if __name__ == '__main__':

    x1, y1 = load_trainning_data("Data1/ADFA-LD/Training_Data_Master/")
    x2, y2 = load_webshell_data("Data1/ADFA-LD/Attack_Data_Master/")
    x = x1 + x2
    y = y1 + y2

    vectorizer = CountVectorizer(min_df = 1)
    x = vectorizer.fit_transform(x)
    x = x.toarray()

    clf = neighbors.KNeighborsClassifier(n_neighbors = 3)
    scores = cross_val_score(clf, x, y, n_jobs = 3, cv = 10)

    #mlp = MLPClassifier(hidden_layer_sizes=(150, 50), max_iter=10, solver='lbfgs', verbose=10)
    #scores = cross_val_score(mlp, x, y, n_jobs=3, cv=10)

    print scores
    print np.mean(scores)
