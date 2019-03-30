#!/usr/bin/env python
import re
import sys  
reload(sys)  
sys.setdefaultencoding('utf8')
from config import *
def is_webshell(filepath,filetype):
    if filetype=='php':
	ali_webshell_rule = ali_webshell_rule_php
    elif filetype=='jsp':
	ali_webshell_rule = ali_webshell_rule_jsp
    content = open(filepath).read()
    if len(content) > max_file_size:
	print "[*]File Skip => " + filepath
	return ("Skip",0) 
    for rulelist in ali_webshell_rule:
	flag = 1
	for rule in rulelist:
	    #print rule['data'] + " => " + filepath
	    if int(rule['type']) == 2:  # type=2 string match
		if content.find(rule['data']) < 0:
		    flag = 0
		    break
	    elif int(rule['type']) == 1: # type=1 regrex
		if not re.search(rule['data'],content):
		    flag = 0
		    break
	if flag:
	    print "[!]webshell find by find=> " + filepath
	    return ("unknown shell by find",1)
    print "[*]File OK => " + filepath
    return ("OK",0)
    
#is_webshell("secure.jsp","jsp") 
