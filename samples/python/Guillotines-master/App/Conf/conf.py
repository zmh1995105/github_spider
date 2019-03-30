#!/usr/bin/env python3
#coding:utf-8

from sqlalchemy import create_engine

def dbconfig():
    engine=create_engine('mysql+pymysql://root:root@localhost:3306/guillotines?charset=utf8')
    return engine

def showShellconfig():
    #每页显示20个webshell
    return 20
