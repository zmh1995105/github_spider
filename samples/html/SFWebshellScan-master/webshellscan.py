#!/bin/env python
# -*- coding:utf-8 -*-

import os
import json
import requests
import time
import datetime
import shutil
import uuid
import argparse
import sys
import base64

class Scanfile(object):
    
    def __init__(self, name, path, token, status=None):
        self.name = name
        self.path = path
        self.token = token
        self.status = status

scanfiles = {}

#collectFile
def collectFile(path):
    filetype = ['php', 'phtml', 'inc', 'php3', 'php4', 'php5', 'war', 'jsp', 'jspx', 'asp', 'aspx', 'cer', 'cdx', 'asa', 'ashx', 'asmx', 'cfm']
    print("开始收集扫描文件")
    os.system('rm -rf SFtmp && mkdir SFtmp')
    os.system('rm -rf SFWebshell.zip')
    for root, dirs, files in os.walk(path):
        for filename in files:
            filext = os.path.splitext(filename)[1]
            if(filext[1:] in filetype):
                token = str(uuid.uuid4())
                tmpfile = Scanfile(filename, root, token)
                scanfiles[token] = tmpfile
                shutil.copyfile(os.path.join(root, filename), './SFtmp/' + token + filext)
    print("开始打包文件内容")
    os.system('zip SFWebshell.zip ./SFtmp/*')
    print("打包成功")

#sendfile
def sendFile():
    print("开始分析文件")
    time.sleep(2)
    sendFileCommand = 'curl https://scanner.baidu.com/enqueue -F archive=@SFWebshell.zip'
    r = os.popen(sendFileCommand).read()
    url = json.loads(r)['url']
    return url

#AnalysisResult
def analysisData(url):
    suspiciousFiles = []
    print("分析文件准备工作结束")
    start_time = datetime.datetime.now()
    time.sleep(15)
    r = requests.get(url).text[:-1]
    json_r = json.loads(r)[0]
    while(int(json_r['total']) != int(json_r['scanned'])):
        time.sleep(5)
        print("已经扫描: %.2f%%" % ((json_r['scanned'] * 1.00 / json_r['total'])*100))
        r = requests.get(url).text[:-1]
        json_r = json.loads(r)[0]
    print("已经扫描: %.2f%%" % ((json_r['scanned'] * 1.00 / json_r['total'])*100))
    duration = (datetime.datetime.now() - start_time).seconds
    print("total:"+str(json_r['total']))
    print("detected:"+str(json_r['detected']))
    print("Webshell is :")
    for item in json_r['data']:
        if(item['descr'] is not None):
            token = item['path'][item['path'].index('/')+1:item['path'].index('.')]
            scanfiles[token].status = item['descr']
            suspiciousFiles.append(scanfiles[token])
    total = json_r['total']
    detected = json_r['detected']
    reporterData(start_time, duration, total, detected, scanfiles)
    return suspiciousFiles
    
#Reporter
def reporterData(start_time, duration, total, detected, result):
    reporter = '''
        <html>
    <head>
        <meta charset="utf-8">
        <title>SFWebShell查杀报告</title>
    </head>
    <body>
        <h1>SFWebShell查杀报告</h1>
        <strong>扫描开始时间:</strong>
        {{ start_time }}
        <br />
        <strong>扫描时长:</strong>
        {{ duration }}
        <br />
        <strong>扫描文件数:</strong>
        {{ total }}
        <br />
        <strong>检测可疑文件数:</strong>
        {{ detected }}
        <br />
        <br />
        <table>
            <tr>
                <th>文件名</th>
                <th>描述</th>
            </tr>
            {{ scan_result }}
        </table>
    </body>
</html>
    '''
    scan_result = ""
    for item in result.values():
        if(item.status is not None):
            scan_result += "<tr><td>{}</td><td>{}</td></tr>".format(item.path+item.name, item.status)
    reporter = reporter.replace("{{ start_time }}", str(start_time)).replace("{{ duration }}", str(duration)).replace("{{ total }}", str(total)).replace("{{ detected }}", str(detected)).replace("{{ scan_result }}", scan_result)
    with open('SFWebshell.html', 'w') as f:
        f.write(reporter)
    print('WebShell scan finished')

#Traces of cleaning
def traceClean():
    print("清理过程文件")
    #os.system('rm -rf SFtmp SFWebshell.zip')
    print("清理结束")

#Files encoding
def fileEncoding():
    pass

#SFWebshell scanner menu
def SFWmenu():
    parser = argparse.ArgumentParser(prog="SFWebshell", description="This is SFWebshell Scanner")
    parser.add_argument("-s", help="Scan spedified directory", type=str)
    parser.add_argument("-v", help="show version", type=str)
    if(len(sys.argv) < 2):
        parser.print_help()
        exit()  
    else:
        args = parser.parse_args()
    return args
    

#File Quarantine
def fileQuarantine(suspiciousFiles):
    for file in suspiciousFiles:
        with open(file, 'rw', encoding='utf-8') as f:
            content = f.read()

args = SFWmenu()
if(args.s):
    collectFile(args.s)
    analysisData(sendFile())
    traceClean()
