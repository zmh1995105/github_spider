#!/usr/bin/python
# -*- coding: utf-8 -*-
import os
import re
import time
import hashlib
from config import *
import tencent
import ali
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
    shell_type_1,is_shell_1 = ali.is_webshell(f,"jsp")
    shell_type_2,is_shell_2 = tencent.is_webshell(f,"jsp")
    if  is_shell_2 or is_shell_1:
	webshell += 1
    else:
	ok_file += 1
	res.append(f)

print rule_hit
print file_match_rule
#print res
print webshell,ok_file,ok_file + webshell
