#!/usr/bin/env python
import hashlib
import re
import sys  
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
	hash_id = hashlib.md5(str(rulelist)).hexdigest()
	res1[hash_id] = rulelist
	#print hash_id + " => " + str(rulelist)
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
	    print "[!]webshell find => " + filepath + ";  hash => " + hash_id
	    if rule_hit.has_key(hash_id):
		rule_hit[hash_id] += 1
	    else:
		rule_hit[hash_id] = 1
	    if file_match_rule.has_key(filepath):
		file_match_rule[filepath].append(hash_id)
	    else:
		file_match_rule[filepath] = [hash_id,]
	    #return ("unknown shell ",1)                 # if not return, the webshell would be checked by all rules
    print "[*]File OK => " + filepath
    return ("OK",0)

res1 = {}    
is_webshell("secure.jsp","jsp") 
print res1
