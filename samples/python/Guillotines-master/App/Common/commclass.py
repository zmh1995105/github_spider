#!/usr/bin/env python3
#coding:utf-8
import urllib.request
import urllib.parse

class WebShellAdmin():
    
    def __init__(self,url,pwd,csdata):
        self.userAgent = {'User-Agent' : 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.69 Safari/537.36'}
        self.requestUrl = url
        self.password=pwd
        self.requestMethod = 'POST'
        self.csdata=csdata
        
        
    def doPost(self):
        userAgent = self.userAgent
        requestUrl = self.requestUrl
        requestMethod = self.requestMethod
        pwd=self.password
        source_data={pwd:self.csdata}
        
        data=urllib.parse.urlencode(source_data).encode('UTF-8')
        mrequest=urllib.request.Request(url=requestUrl,data=data,headers = userAgent, method = requestMethod)
        
        try:
            response_data=urllib.request.urlopen(mrequest).read().decode('utf-8')
            mcode=urllib.request.urlopen(mrequest).code
            return response_data,mcode
        except Exception as e:
            print(e)
            return ('0',404)

