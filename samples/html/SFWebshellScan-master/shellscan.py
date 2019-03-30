#!/usr/bin/python
# -*- coding: utf-8 -*-

import os
import sys
import re

rulelist = [
    '(\$_(GET|POST|REQUEST)\[.{0,15}\]\(\$_(GET|POST|REQUEST)\[.{0,15}\]\))',
    '(base64_decode\([\'"][\w\+/=]{200,}[\'"]\))',
    'eval\(base64_decode\(',
    '(eval\(\$_(POST|GET|REQUEST)\[.{0,15}\]\))',
    '(assert\(\$_(POST|GET|REQUEST)\[.{0,15}\]\))',
    '(\$[\w_]{0,15}\(\$_(POST|GET|REQUEST)\[.{0,15}\]\))',
    '(wscript\.shell)',
    '(gethostbyname\()',
    '(cmd\.exe)',
    '(shell\.application)',
    '(documents\s+and\s+settings)',
    '(system32)',
    '(serv-u)',
    '(提权)',
    '(phpspy)',
    '(后门)',
    '(webshell)',
    '(Program\s+Files)'
]

def Scan(path):
    scount = 0
    for root,dirs,files in os.walk(path):
        for filespath in files:
            isover = False
            if '.' in filespath:
                ext = filespath[(filespath.rindex('.')+1):]
                if ext=='php':
                    file= open(os.path.join(root,filespath))
                    filestr = file.read()
                    file.close()
                    for rule in rulelist:
                        result = re.compile(rule).findall(filestr)
                        if result:
                            print '文件：'+os.path.join(root,filespath)
                            print '恶意代码：'+str(result[0])
                            print '\n\n'
                            scount += 1
                            break
    print('count:'+str(scount))
    
if os.path.lexists(sys.argv[1]):
    print('\n\n开始扫描：'+sys.argv[1])
    print('               可疑文件                 ')
    print('########################################')
    Scan(sys.argv[1])
    print('提示：扫描完成-- O(∩_∩)O哈哈~')
else:
    print '提示：指定的扫描目录不存在---  我靠( \'o′)！！凸'
