#!/usr/bin/python
# -*- coding: utf-8 -*-


'''
this script is to Analysis big logfile.
'''


import os
import re
import threading
import sys
from multiprocessing.dummy import Pool as ThreadPool
import time


# 规则列表
rulelist = ['\.\./','select.+(from|limit)','(?:(union(.*?)select))','having|rongjitest','sleep\((\s*)(\d*)(\s*)\)','benchmark\((.*)\,(.*)\)','base64_decode\(','(?:from\W+information_schema\W)','(?:(?:current_)user|database|schema|connection_id)\s*\(','(?:etc\/\W*passwd)','into(\s+)+(?:dump|out)file\s*','group\s+by.+\(','xwork.MethodAccessor','(?:define|eval|file_get_contents|include|require|require_once|shell_exec|phpinfo|system|passthru|preg_\w+|execute|echo|print|print_r|var_dump|(fp)open|alert|showmodaldialog)\(','xwork\.MethodAccessor','(gopher|doc|php|glob|file|phar|zlib|ftp|ldap|dict|ogg|data)\:\/','java\.lang','\$_(GET|post|cookie|files|session|env|phplib|GLOBALS|SERVER)\[','\<(iframe|script|body|img|layer|div|meta|style|base|object|input)','(onmouseover|onerror|onload)\=','(HTTrack|harvest|audit|dirbuster|pangolin|nmap|sqln|-scan|hydra|Parser|libwww|BBBike|sqlmap|w3af|owasp|Nikto|fimap|havij|PycURL|zmeu|BabyKrokodil|netsparker|httperf|bench| SF/)','\.(svn|htaccess|bash_history)','\.(bak|inc|old|mdb|sql|backup|java|class)$','(vhost|bbs|host|wwwroot|www|site|root|hytop|flashfxp).*\.rar','(phpmyadmin|jmx-console|jmxinvokerservlet)','/(attachments|upimg|images|css|uploadfiles|html|uploads|templets|static|template|data|inc|forumdata|upload|includes|cache|avatar)/(\\w+).(php|jsp)']


def File_Search(filename):
    content = open(filename).readlines()
    pool = ThreadPool(500)
    results = pool.map(Log_Analysis, content)
    pool.close()
    pool.join()


def Log_Analysis(content):
    for regex in rulelist:
        m = re.search(regex,content)
        if m:
            r.write('匹配特征字符:' + '[' + m.group(0) + ']' + '===>' + content + '\n')
    return 'True'




if __name__ == '__main__':
    if len(sys.argv) < 2:
        print "Usage: log_SecAnalysis.py filename"
        sys.exit(0)
    else:
        start = time.clock()
        print '====> Log is analyzing, please wait for a moment <==== '
        r = open('result.txt', 'a')  # 需要本地先新建个result.txt文件
        r.write('\n' + '=================== web_log_secAnalysis ===================' + '\n' + sys.argv[1] + '\n')
        File_Search(sys.argv[1])
        end = time.clock()
        print '分析完毕,共运行时长:' + str(end - start)
        sys.exit(0)




