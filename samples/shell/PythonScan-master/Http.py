#!/usr/bin/python
# -*- coding: UTF-8 -*-

'''
Auth: stone
Time: 2018-08-21
Describe: http请求模块—独立
'''

'''
引入官方库文件
Introducing the official library file
'''
import urllib2

'''
Post 请求模块
Post request module
'''
def http_post( url, param='' ):
    urlParam = urllib2.Request(url=url, data=param) 
    response = urllib2.urlopen(urlParam)
    return response.read()

'''
Get 请求模块
Get request module
'''
def http_get( url, param='' ):
    urlParam = urllib2.Request(url=url)
    response = urllib2.urlopen(urlParam)
    return response.read()



