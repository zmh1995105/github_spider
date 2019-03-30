#!/usr/bin/env python3
#coding:utf-8
from random import sample
import hashlib
import re
import json

#MD5加密
def makePass(pwd):
    m=hashlib.md5()
    m.update(pwd.encode('utf-8'))
    saltpass=m.hexdigest()
    return saltpass

#生成一个10位salt
def randSalt():
    list=['0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z']
    salt=sample(list,10)
    #把生成的list转换为8位的字符串
    strlist=""
    strlist=strlist.join(salt)
    return str(strlist)

#简单的过滤XSS的函数，你们可以再此基础上丰富下
def checkxss(content):
    sb=content
    sb=re.sub(r"&","__&__",sb,0,re.I)
    sb=re.sub(r"'","`",sb,0,re.I)
    sb=re.sub(r'""','__"__',sb,0,re.I)
    sb=re.sub(r"<","__<__",sb,0,re.I)
    sb=re.sub(r">","__>__",sb,0,re.I)
    sb=re.sub(r"/","__/__",sb,0,re.I)
    return sb


def checkuname(content):
    sb=content
    uname=re.match(r'^[a-zA-Z][a-zA-Z0-9_]{2,50}',sb)
    if uname:
        return uname.group()
    else:
        return None
    
def checktel(content):
    sb=content
    phone=re.match('^0\d{2,3}\d{7,8}$|^1[358]\d{9}$|^147\d{8}',sb)
    if phone:
        return phone.group()
    else:
        return None
    
def checkemail(content):
    sb=content
    uemail=re.match('^.+\\@(\\[?)[a-zA-Z0-9\\-\\.]+\\.([a-zA-Z]{2,3}|[0-9]{1,3})(\\]?)$',sb)
    if uemail:
        return uemail.group()
    else:
        return None
    
def urlToip(url):
    return ip
