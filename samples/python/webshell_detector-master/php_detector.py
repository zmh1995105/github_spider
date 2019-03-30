#!/usr/bin/python
# -*- coding: utf-8 -*-
import os
import re
import time
import hashlib
from config import *
import tencent

def md5(string):
    return hashlib.md5(string).hexdigest()
pathdir = '/root/php_sample'	
wis = 'php|php5|php7|pht|inc|phtml'
filepaths = []	    
for fpathe,dirs,fs in os.walk(pathdir):
    for f in fs:
        ppp = os.path.join(fpathe,f)
        if os.path.isfile(ppp) and re.match(r'^\.('+wis+')$',os.path.splitext(ppp)[1]):
            filepaths.append(ppp)
webshell = 0
ok_file = 0
for f in filepaths:
    shell_type,is_shell = tencent.is_webshell(f,"php")
    if is_shell:
	webshell += 1
    else:
	ok_file += 1
print webshell,ok_file,ok_file + webshell
