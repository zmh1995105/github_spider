#!/usr/bin/python
# -*- coding: utf-8 -*-
import os
import re
import time
import hashlib
from config import *
import all
import sys


def md5(string):
    return hashlib.md5(string).hexdigest()
pathdir = '/root/jsp_sample'	
pathdir = sys.argv[1]
wis = 'jsp|jspx'
filepaths = []	    
for fpathe,dirs,fs in os.walk(pathdir):
    for f in fs:
        ppp = os.path.join(fpathe,f)
        if os.path.isfile(ppp) and re.match(r'^\.('+wis+')$',os.path.splitext(ppp)[1]):
            filepaths.append(ppp)
webshell = 0
ok_file = 0
res = []
for f in filepaths:
    shell_type,is_shell = all.is_webshell(f,"jsp")
    if  is_shell:
	webshell += 1
    else:
	ok_file += 1
	res.append(f)
    print "###################### REST #########################"
    time.sleep(time_span)

print rule_hit
print file_match_rule
#print res
print webshell,ok_file,ok_file + webshell
