#!/usr/bin/env python

import hashlib
from config import *

all_rules  = {}

ali_webshell_rule = ali_webshell_rule_jsp
tencent_webshell_rule = tencent_webshell_rule_jsp 
for rulelist in ali_webshell_rule:
    hash_id = hashlib.md5(str(rulelist)).hexdigest()
    all_rules[hash_id] = rulelist

for rule in tencent_webshell_rule:
    hash_id = hashlib.md5(str(rule[3])).hexdigest()
    shell_regrex = rule[3]
    rulelist = [{"type":"1","data":rule[3]}]
    all_rules[hash_id] = rulelist   
print all_rules
