#!/usr/bin/env python
import hashlib
import re
from config import *
def is_webshell(filepath,filetype):
    if filetype=='php':
	tencent_webshell_rule = tencent_webshell_rule_php
    elif filetype=='jsp':
	tencent_webshell_rule = tencent_webshell_rule_jsp
    content = open(filepath).read()
    for rule in tencent_webshell_rule:
	hash_id = hashlib.md5(str(rule[3])).hexdigest()
	shell_type = rule[0]
	shell_regrex = rule[3]
	if re.findall(shell_regrex,content):
	    print "[!]webshell find => " + filepath + " shell_type => " + shell_type + " hash => " + hash_id 
	    if rule_hit.has_key(hash_id):
                rule_hit[hash_id] += 1
            else:
                rule_hit[hash_id] = 1 
            if file_match_rule.has_key(filepath):
                file_match_rule[filepath].append(hash_id)
            else:
                file_match_rule[filepath] = [hash_id,] 
	    #return (shell_type,1)
    print "[*]File OK => " + filepath
    return ("OK",0)
     
