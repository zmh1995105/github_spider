#/usr/bin/env python
#-*-cofing:utf8-*-
#shellscan about webshell (asp,aspx,php,jsp)
#coding by jusker
#
##############################################
#               china web security           #
#                    jusker                  # 
##############################################
import os
import time
import threading
import sys
class SystemScan(threading.Thread):
	def __init__(self,scanpath,payloadpath, payload):
		threading.Thread.__init__(self)
		self.__scanpath = scanpath
		self.__payload = payload
		self.__payloadpath = payloadpath
	def run(self):
		self.__cmd = 'python ' + self.__payloadpath + self.__payload + ' ' + self.__scanpath
		os.system(self.__cmd)
#print self.__filePayloads
if __name__ == '__main__':
	print 'my heart blood just for my thinking###########################start time:' + time.strftime('%Y-%m-%d %X', time.localtime())
	threads = []
	scanDir = sys.argv[1]
	allPayload =  os.listdir('./script')
	for myPayload in allPayload:
		realpath = os.getcwd() + '/script/'
		filepath  = os.path.join(realpath, myPayload)
		threads.append(SystemScan(scanDir,realpath, myPayload))
	for t in threads:
		t.start()
	for t in threads:
		t.join()
	print 'task my heart just for make dream become simply------------> stop time:' + time.strftime('%Y-%m-%d %X',time.localtime())
