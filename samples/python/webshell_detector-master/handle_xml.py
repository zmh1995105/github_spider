#!/usr/bin/env python

import xml.dom.minidom

res = []
root = xml.dom.minidom.parse("ali.xml").documentElement
for elm in root.childNodes:
    if elm.nodeType == elm.ELEMENT_NODE:
	rules = elm.getElementsByTagName('Rule')
	res_2 = []
	for rule in rules:
	    tmp = {}	
	    tmp['type'] = rule.getElementsByTagName('Type')[0].childNodes[0].data
	    tmp['data'] = rule.getElementsByTagName('Data')[0].childNodes[0].data
	    res_2.append(tmp)
	res.append(res_2)
print res
