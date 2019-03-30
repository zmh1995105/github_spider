#!/usr/bin/env python

from config import *
import re
import sys

def all_rules():
    for rulelist_hash in webshell_rules:
	init_rules[rulelist_hash] = 1
    print len(init_rules),init_rules

if len(sys.argv) <= 2:
    all_rules()
else:
    tmp = sys.argv[2].split(',')
    i = 0
    for rulelist_hash in init_rules:
	init_rules[rulelist_hash] = tmp[i]
	i += 1
    print len(init_rules),init_rules


def is_webshell(filepath,filetype):
    content = open(filepath).read()
    if len(content) > max_file_size:
	print "[*]File Skip => " + filepath
        return ("Skip",0)
    for rulelist_hash in webshell_rules:
	if(init_rules[rulelist_hash]):
	    flag = 1 
	    for rule in webshell_rules[rulelist_hash]:
		if int(rule['type']) == 2:  # type=2 string match
		    if content.find(rule['data']) < 0:
			flag = 0 
                        break
		elif int(rule['type']) == 1: # type=1 regrex
		    if not re.search(rule['data'],content):
			flag = 0 
			break
            if flag:
	        print "[!]webshell find => " + filepath + ";  hash => " + rulelist_hash
		return ("Unkown shell",1)
    print "[*]File OK => " + filepath
    return ("OK",0)
   
#is_webshell("secure.jsp","jsp")	
