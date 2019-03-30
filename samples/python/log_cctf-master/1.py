import os,sys
from time import sleep,ctime
import re

global list_time
global log
list_time = []
log = open('log.txt', 'a+')
print '[+] log.txt creat at %s' % (os.pardir + os.sep + 'log.txt')

def getTime(fileurl):
	global list_time
	try:
		os.chdir(fileurl)
	except Exception, e:
		print e
		sys.exit()
	list_dir = os.listdir(os.curdir)

	if not list_dir:
		print '[!] There is nothing in %s' % (os.getcwd())
		os.chdir(os.pardir)
	else:
		for i in list_dir:
			if os.path.isfile(i):
				list_time.append(int(os.path.getmtime(i)))
			if os.path.isdir(i):
				# if i == '.git':
				# 	continue
				getTime(i)
				os.chdir(os.pardir)
	max_time = sorted(list_time)[-1]
	return max_time

def delshell(fileurl ,max_time):
	global log
	output = ''
	os.chdir(fileurl)
	list_dir = os.listdir(os.curdir)
	
	if not list_dir:
		output = '[!] Delete an empty dir',os.getcwd()
		#log.write(output)
		print output
		os.chdir(os.pardir)
		os.rmdir(fileurl)
	else:
		for i in list_dir:
			if os.path.isfile(i):
				file_time = int(os.path.getmtime(i))
				file_size = os.path.getsize(i)
				if max_time < file_time:
					output = '[!] ' + ctime() + ' Find a suspicious file:'+os.getcwd()+os.sep+i
					log.write(output + '\n')
					log.flush()
					print output
					output = ''
					# if i != '.DS_Store':
					output += '=' * 20 + '\n' 
					output += openFile(i) + '\n'
					output += '=' * 20 + '\n'
					log.write(output + '\n')
					print output
					os.remove(i)
				elif file_size < 200:
					if attribute_code_shell(i):
						output = '[!] ' + ctime() + ' Find a suspicious file:'+os.getcwd()+os.sep+i
						log.write(output)
						log.flush()
						print output
						output = ''
						# if i != '.DS_Store':
						output += '=' * 20 + '\n' 
						output += openFile(i) + '\n'
						output += '=' * 20 + '\n'
						log.write(output)
						print output
						os.remove(i)
				log.flush()
			if os.path.isdir(i):
				delshell(i ,max_time)
				os.chdir(os.pardir)

def openFile(filename):
	try:
		f = open(filename, 'r')
		content = f.read()
		f.close()
		return content
	except Exception, e:
		return str(e)

def check_time_log():
	path = 'time.txt'
	if os.path.exists(path):
			f = open(path, 'r')
			max_time = f.read()
			f.close()
			return int(max_time)
	return False

def attribute_code_shell(filename):
	content = openFile(filename)
	m = re.match('[\S\s]+eval\(\$_POST\[.+\]\)[\S\s]+|[\S\s]+eval\(\$_GET\[.+\]\)[\S\s]+|[\S\s]+system\(\$_GET\[.+\]\)[\S\s]+|[\S\s]+system\(\$_GET\[.+\]\)[\S\s]+' ,content)
	if m:
		return True
	return False

def main(fileurl):
	while True:
		time.sleep(5)
		delshell(fileurl)

if __name__ == '__main__':
	global log
	if not len(sys.argv) > 1:
		print '[!] get_time.py must get a parameter!\nUsage:python %s path' % sys.argv[0]
	elif sys.argv[1]:
		path = os.getcwd()
		path += os.sep + sys.argv[1]
		print '[+] Get path ==>',path
		if check_time_log():
			MAX_TIME = check_time_log()
			print "[+] Use time.txt"
		else:
			print "[+] No time.txt . Tring to get max time"
			MAX_TIME = getTime(path)
			f = open(os.pardir + os.sep + 'time.txt', 'wb')
			f.write(str(MAX_TIME))
			f.close()
		print '[+] Get max time ==>',MAX_TIME
		print '[+] time.txt creat at %s' % (os.pardir + os.sep + 'time.txt')
		print '[+] Start checking'
		while True:
			sleep(3)
			delshell(path, MAX_TIME)
