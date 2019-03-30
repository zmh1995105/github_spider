import re
import os
import numpy as np
from sklearn.feature_extraction.text import CountVectorizer
from sklearn.model_selection import cross_val_score
from sklearn.naive_bayes import GaussianNB
from sklearn import neighbors
from sklearn import svm
from sklearn.neural_network import MLPClassifier

def load_str(filepath):
    t = ""
    with open(filepath) as f:
        for line in f:
            line = line.strip('\n')
            t += line
    return t

def load_wp_str(path):
    files_list = []
    for r, d, files in os.walk(path):
        for file in files:
            if file.endswith('.php'):
                file_path = path + file
                print "Load %s" % file_path
                t = load_str(file_path)
                files_list.append(t)
    return files_list

def dirlist(path, allfile):
    filelist = os.listdir(path)
    for filename in filelist:
        filepath = os.path.join(path, filename)
        if os.path.isdir(filepath):
            dirlist(filepath, allfile)
        else:
            allfile.append(filepath)
    return allfile

def load_wbshell_str(path):
    allfile = dirlist(path, [])
    for file in allfile:
        if file.endswith('.php'):
            file_path = path + file
            print "Load %s" % file_path
            t = load_str(file_path)
            allfile.append(t)
    return allfile

if __name__ == '__main__':

    webshell_bigram_vectorizer = CountVectorizer(ngram_range = (2, 2), decode_error = 'ignore', token_pattern = r'\b\w', min_df = 1)
    webshell_files_list = load_wbshell_str("Data2/PHP-WEBSHELL/../../")
    x1 = webshell_bigram_vectorizer.fit_transform(webshell_files_list).toarray()
    y1 = [1]*len(x1)
    vocabulary = webshell_bigram_vectorizer.vocabulary_

    wp_bigram_vectorizer = CountVectorizer(ngram_range = (2, 2), decode_error = 'ignore', token_pattern = r'\b\w', min_df = 1, vocabulary = vocabulary)
    wp_files_list = load_wp_str("Data2/wordpress/")
    x2 = wp_bigram_vectorizer.fit_transform(wp_files_list).toarray()
    y2 = [0]*len(x2)

    x = np.concatenate((x1, x2))
    y = np.concatenate((y1, y2))

    #clf = GaussianNB()
    #clf = neighbors.KNeighborsClassifier(n_neighbors = 20)
    #clf = svm.SVC(kernel = 'linear', C = 1)
    #scores = cross_val_score(clf, x, y, n_jobs = 3, cv = 3)

    mlp = MLPClassifier(hidden_layer_sizes=(150, 50), max_iter=10, solver='lbfgs', verbose=10)
    scores = cross_val_score(mlp, x, y, n_jobs=3, cv=10)

    print scores
    print np.mean(scores)

