#/usr/bin/env python
#-*-coding:utf8-*-
import os
import time
import re
import sys
from time import localtime
from time import strftime
#############################
#php eval/assert shell scan payload
#############################
class Myscan():
#
	def __init__(self, scandir):
		self.__scandir = scandir
		self.__filePathFiles = []
		self.__payload = 'PhpDdos/socket tcp udp :torjan'
	def osWalkFile(self):
		for self.__root, self.__dir, self.__files in os.walk(self.__scandir):
			for self.__filePath in self.__files:
				self.__filePathFiles.append(os.path.join(self.__root, self.__filePath))
		self.reCodeDefine()
		self.filesDisplay()
#self.reCodeDefine()
	def reCodeDefine(self):
		self.__ruleReList  = [
		'(启动自动攻击)',
		'(phpddos)',
		'(aspxddos)',
		'(jspddos)',
		'(fsockopen\("udp:)',
		'(fsockopen\("tcp:)',
		'(\$_GET\[\w{0,10}\]=="udp")'
		]
	def reFileCompile(self):
		if os.path.getsize(self.__oneFile) < 10024:
			for self.__rule in self.__ruleReList:
				self.__result = re.search(self.__rule, self.__needReFileRead)
				if self.__result:
					print 'Payload:' + self.__payload
					print 'Catalogue:'+ self.__oneFile
					print 'Trojan'+ str(self.fileGetctime()) + '----vlun shell code:' + self.__result.group(0) + str(self.fileGetmtime())
		else:
			pass
				
	def fileGetctime(self):
		return 'file create time:' + strftime("%Y-%m-%d %X", localtime(os.path.getctime(self.__oneFile)))
	def fileGetmtime(self):
		return 'file rename time:' + strftime("%Y-%m-%d %X", localtime(os.path.getmtime(self.__oneFile)))
	def openDirFiles(self):
		self.__openFile = open(self.__oneFile, 'r')
		self.__needReFileRead = self.__openFile.read()
		self.__openFile.close()
	def filesDisplay(self):
		for self.__oneFile in self.__filePathFiles:
			self.openDirFiles()
			self.reFileCompile()
	def scanMain(self):
		self.osWalkFile()
if __name__ == "__main__":
	sysArgv = sys.argv[1] 
	scan = Myscan(sysArgv)
	scan.scanMain()
