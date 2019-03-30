# coding:utf-8
import datetime
import hashlib
import json
import os
import pickle
import time
import warnings

import numpy as np
from sklearn import naive_bayes
from sklearn.ensemble import RandomForestClassifier
from sklearn.externals import joblib
from sklearn.feature_extraction.text import (CountVectorizer, TfidfTransformer,
                                             TfidfVectorizer)
from sklearn.linear_model import LogisticRegression
from sklearn.metrics import (accuracy_score, classification_report,
                             precision_score, recall_score)
from sklearn.model_selection import GridSearchCV, train_test_split
from sklearn.neural_network import MLPClassifier

warnings.filterwarnings("ignore")


class WAF(object):

    def __init__(self):

        good_query_list = self.load_files('/source') #正常样本集
        bad_query_list = self.load_files('/webshell-sample') #恶意样本集
        
        good_y = [0 for i in range(0,len(good_query_list[0]))]
        bad_y = [1 for i in range(0,len(bad_query_list[0]))]

        queries = bad_query_list[0]+good_query_list[0]
        y = bad_y + good_y

        #converting data to vectors  定义矢量化实例
        self.vectorizer = TfidfVectorizer(tokenizer=self.get_ngrams,decode_error="ignore",token_pattern=r'\b\w+\b',ngram_range=(2, 2),min_df=1)



        # 把不规律的文本字符串列表转换成规律的 ( [i,j],tdidf值) 的矩阵X
        # 用于下一步训练分类器 lgs
        X = self.vectorizer.fit_transform(queries)

        # 使用 train_test_split 分割 X y 列表
        # X_train矩阵的数目对应 y_train列表的数目(一一对应)  -->> 用来训练模型
        # X_test矩阵的数目对应 	 (一一对应) -->> 用来测试模型的准确性
        X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.4, random_state=0) # train_size=0.8

        # 多种算法测试
        self.lgs = RandomForestClassifier(n_estimators=100,oob_score=True,random_state=10,n_jobs=4)
        # self.lgs = LogisticRegression(random_state=10,n_jobs=4)
        # self.lgs = MLPClassifier(activation='relu', solver='sgd', alpha=0.0001)
        # self.lgs = naive_bayes.GaussianNB()

        # 使用算法测试训练模型实例 lgs
        self.lgs.fit(X_train, y_train)

        self.y = y_test
        
        # 使用测试值 对 模型的准确度进行计算
        print ('正常样本数量:{}'.format(len(good_query_list[0])))
        print ('恶意样本数量:{}'.format(len(bad_query_list[0])))
        print ('模型的准确率:{}'.format(precision_score(y_test,self.lgs.predict(X_test))))
        print ('模型的召回率:{}'.format(recall_score(y_test,self.lgs.predict(X_test))))

    
    # 对新的请求列表进行预测
    def predicts(self,paths):

        rfdefaultnum = 0
        rfshellnum = 0
        X_predict = self.vectorizer.transform(paths[0])
        # print(self.vectorizer.get_feature_names())
        res = self.lgs.predict(X_predict)
        for path,result in zip(paths[0],res):
            if result == 0:
                # tmp = '正常文件'
                rfdefaultnum += 1
                # print (paths[1][self.source_md5(path)])
            else:
                # tmp = '恶意文件'
                rfshellnum += 1
                print (paths[1][self.source_md5(path)])
        print ('检测到正常文件: {} 个，恶意文件: {} 个'.format(rfdefaultnum,rfshellnum))
        return
    
    def predict(self,paths):

        rfdefaultnum = 0
        rfshellnum = 0
        X_predict = self.vectorizer.transform(paths)
        # print(self.vectorizer.get_feature_names())
        res = self.lgs.predict(X_predict)
        for path,result in zip(paths,res):
            if result == 0:
                # tmp = '正常文件'
                rfdefaultnum += 1
                # print (paths[1][self.source_md5(path)])
            else:
                # tmp = '恶意文件'
                rfshellnum += 1
                # print (paths[1][self.source_md5(path)])
        print ('检测到正常文件: {} 个，恶意文件: {} 个'.format(rfdefaultnum,rfshellnum))
        return ('检测到正常文件: {} 个，恶意文件: {} 个'.format(rfdefaultnum,rfshellnum))
            

    def source_md5(self,source):

        return str(hashlib.md5(source).hexdigest())

    
    def load_file(self,file):
        source = b''
        with open(file, "rb") as f:
            for line in f:
                line = line.strip(b'\r\n')
                source += line
        return source

    def load_files(self,path):
        files = []
        source_json = {}
        for pathname,b,filelist in os.walk(path):
            for file in filelist:
                if file.endswith('.php'):
                    source = self.load_file(pathname+'/'+file)
                    source_json[str(self.source_md5(source))] = pathname+'/'+file
                    files.append(source)
        return files,source_json


    #tokenizer function, this will make 3 grams of each query
    def get_ngrams(self,query):
        tempQuery = str(query)
        ngrams = []
        for i in range(0,len(tempQuery)):
            ngrams.append(tempQuery[i:i+3])
        # print(ngrams)
        return ngrams





if __name__=='__main__':
    pass
    
    # 若 检测模型文件lgs.pickle 不存在,需要先训练出模型
    # starttime = datetime.datetime.now()
    # w = WAF()
    # with open('rf.pickle','wb') as output:
	#     pickle.dump(w,output)
    # endtime = datetime.datetime.now()
    # print ('耗时: {}'.format(endtime - starttime))
    
    # with open('rf.pickle','rb') as input:
    #     starttime = datetime.datetime.now()
    #     print ("加载算法模型...")
    #     w = pickle.load(input)
    #     print ("加载检测文件...")
    #     filelist = w.load_files('/Users/latec0mer/Workspace/ewebshell/test')
    #     print ("检测到 {} 个PHP文件".format(len(filelist[0])))
    #     print ("开始检测...")
    #     w.predict(filelist)
    #     # print (filelist[1])
    
    #     endtime = datetime.datetime.now()
    #     print ('耗时: {}'.format(endtime - starttime))
