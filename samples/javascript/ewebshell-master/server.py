# coding:utf-8
import datetime
import hashlib
import json
import os
import pickle
import time
import warnings

import django
os.environ['DJANGO_SETTINGS_MODULE'] = 'ewebshell.settings'  # 配置系统变量
django.setup()
import numpy as np
import tornado.httpserver
import tornado.ioloop
import tornado.options
import tornado.web
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
from tornado.escape import json_decode, json_encode, utf8
from tornado.options import define, options

from check import WAF
from database import models


warnings.filterwarnings("ignore")


# 若 检测模型文件lgs.pickle 不存在,需要先训练出模型
if os.path.exists('rf.pickle') == False:
    starttime = datetime.datetime.now()
    w = WAF()
    with open('rf.pickle','wb') as output:
        pickle.dump(w,output)
    endtime = datetime.datetime.now()
    print ('耗时: {}'.format(endtime - starttime))
else:
    pass

with open('rf.pickle','rb') as input:
    print ("加载算法模型...")
    w = pickle.load(input)


define("port", default=8080, type=int)


class upload(tornado.web.RequestHandler):

    def post(self):
            file_metas = self.request.files["file"]          
            starttime = datetime.datetime.now()
            print ("加载检测文件...")
            filecontent = []
            filecontent.append(file_metas[0]['body'])
            endtime = datetime.datetime.now()
            self.write(w.predict(filecontent))
            self.write('\n耗时: {}'.format(endtime - starttime))
        
            # import os                                           #引入os路径处理模块
            # with open(os.path.join('statics','img',file_name),'wb') as up:            
            #     up.write(meta['body'])                                                #将文件写入到保存路径目录
            #     self.write(os.path.join('statics','img',file_name))                   #将上传好的路径返回

    def get(self):
        self.render('upload.html')


class task_add():
    
    def post(self):

        pass
    
    def get(self):
        # models.webshell.objects.create(task_id='123123',webshell_filepath='test',webshell_md5='12333')
        for a in models.webshell.objects.filter(task_id='123123'):
            print (a.task_id)
        



if __name__ == '__main__':

    template_path = os.path.join(os.path.dirname(__file__), "template")
    static_path=os.path.join(os.path.dirname(__file__), "statics")

    tornado.options.parse_command_line()
    app = tornado.web.Application(handlers=[
        (r"/", upload)
    ],debug=True,template_path=template_path,static_path=static_path,)
    http_server = tornado.httpserver.HTTPServer(app)
    http_server.listen(options.port)
    tornado.ioloop.IOLoop.instance().start()
