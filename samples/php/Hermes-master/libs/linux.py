# _*_ coding: utf-8 _*_
#
# @function: scanner for linux system
# @author: Alvin
# @create time: 2018.2.7

import os
import socket
import re
import time
from urllib import request, parse
from traceback import print_exc


# 设置白名单
pass_file = ["api_ucenter.php"]

# 记录报告的服务器地址
# req_url = 'http://127.0.0.1:8000/wbs/add/'
req_url = 'http://10.3.14.72/add.ashx'


def send_report(ip, hostname, file_path, rule, describe):

    try:
        req_data = {
            'ip': ip,
            'hostname': hostname,
            'file_path': file_path,
            'rule': rule,
            'describe': describe
        }
        querystring = parse.urlencode(req_data)

        req = request.urlopen(url=req_url, data=querystring.encode('ascii'))
        return req.read()

    except:
        print(print_exc())
        return False


# 设置搜索特征码
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
    '(jspspy)',
    '(后门)',
    '(webshell)',
    '(Program\s+Files)',
    'www.phpdp.com',
    'phpdp',
    'PHP神盾',
    'decryption',
    'Ca3tie1',
    'GIF89a',
    'choraheiheihei',
    'jshell',
    'jsp File browser',
    'IKFBILUvM0VCJD\/APDolOjtW0tgeKAwA',
    '\'e\'\.\'v\'\.\'a\'\.\'l\'',
    '\'a\'\.\'s\'\.\'s\'\.\'e\'\.\'r\'\.\'t\'',

    'shellname',
    'dlform',
    'phpc.sinaapp.com',
    '6d31b7d21395a26b8035fdd7b94bb070d5993de3',
    'HpDmKuzaIwgtAJBigP1odZm0Btz7lL',
    'x65rt',
    '$_POST["gutou"]',
    'phpinfo',
    '(preg_replace(\s|\n)*\(.{1,100}[/@].{0,3}e.{1,6},.{0,10}\$_(GET|POST|REQUEST))',
    'shell_exec',
    '(call_user_func\(.{0,15}\$_(GET|POST|REQUEST))',
]


def Scan(path):
    for root, dirs, files in os.walk(path):
        for filespath in files:
            if '.' in filespath:
                ext = filespath[(filespath.rindex('.')+1):]
                # print ext
                if ext in ['jsp', 'jspx', 'php', 'aspx', 'asp', 'cer', 'asa', 'ashx', 'do']:
                    # print ext
                    if filespath not in pass_file:
                        file = open(os.path.join(root, filespath), encoding='latin-1')
                        filestr = file.read()
                        file.close()
                        for rule in rulelist:
                            result = re.compile(rule).findall(filestr)
                            if result:

                                a = 'Found_File: '+os.path.join(root, filespath)+'\n'
                                b = 'Webshell_Rule: '+str(result[0])+'\n'
                                c = 'File_Of_Time: '+time.strftime('%Y-%m-%d %H:%M:%S', time.localtime(os.path.getmtime(os.path.join(root, filespath))))+'\n'
                                d = '\n\n'
                                print(a, b, c)

                                hostname = socket.gethostname()
                                try:
                                    target_ip = socket.gethostbyname(socket.gethostname())
                                except:
                                    target_ip = ''
                                file_path = os.path.join(root, filespath)
                                rule = str(result[0])

                                # check file size, if size > 500k, don't save file content
                                if len(filestr)/1024 > 500:
                                    describe = ''
                                else:
                                    describe = filestr

                                if send_report(target_ip, hostname, file_path, rule, describe):
                                    print("Send report success!\n\n")
                                else:
                                    print("Send report failed!\n\n")

                                with open(hostname + '.txt', 'a') as f:
                                    f.write(a+b+c+d)
                                break


try:
    print('\n\nBegin Scan from root path: /')
    print('--------------------Scan Begin-----------------------------------')
    Scan('/')
    print('--------------------Scan Done------------------------------------')
except IndexError:
    print("Define dir to scan")

