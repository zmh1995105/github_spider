#!/usr/bin/env python3
#coding:utf-8

from App.Common.utils import checkxss,checkemail,makePass
from App.Model.models import User

def checkLogin(db,email,pwd):
    try:
        email=checkemail(email)

        pwd=makePass(pwd)
        print(pwd)
        user=db.query(User).filter(User.EMAIL==email).first()
        if user:
            salt=user.SALT
            md5pass=makePass(pwd+salt)
            print(md5pass)
            if user.PWD==md5pass:
                return "sucess"
            else:
                return "error"
        else:
            return "error"
    except Exception as e:
        return e
