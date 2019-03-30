#!/usr/bin/python
# -*-coding: UTF-8-*-

'''
Author: stone
Time: 2018-08-20
Describe: 木马文件扫描
'''

'''
引入官方库文件
Introducing the official library file
'''
import os
import json
import shutil

'''
引入本地库文件
Introducing local library files
'''
import Config
import Http

'''
初始化木马文件次数
Initialize the number of Trojan files
'''
trojan_number = 0
trojan_route = '/root/PythonTools/functions'

'''
请求服务器清除木马规则，并已json格式返回
Ask the server to clear Trojan rules
根据规则循环清除
Cycle clear according to rules
'''
def clear_trojan_rule():
    trojan_rule_url = Config.get_config_values('TrojanRule', 'url')
    trojan_result = Http.http_get( trojan_rule_url )
    res_json = json.loads(trojan_result, encoding="utf-8")
    for index in range(len(res_json)):
        #print hjons[index]['nickname']
        scan_trojan( res_json[index]['content'], res_json[index]['route'] )

'''
param: 
判断备份目录是否存在
Determine if the backup directory exists
存在拷贝非法篡改文件到备份
Copying illegal tampering files to backup
不存在则创建备份目录，并拷贝非法文件到备份目录中
Create a backup directory if it does not exist, and copy the illegal file to the backup directory.
'''
def scan_trojan( trojan_param, trojan_route ):
    backups_dir = Config.get_config_values('backupsDir', 'backups_dir')
    if ( os.path.exists(trojan_route) ):
        if ( os.path.isdir( backups_dir )):
            shutil.copyfile(trojan_route, backups_dir + trojan_route.split('/')[-1])
            file_find_str( trojan_param, trojan_route )
        else:
            os.makedirs( backups_dir )
            shutil.copyfile(trojan_route, backups_dir + trojan_route.split('/')[-1])
            file_find_str( trojan_param, trojan_route )
    else:
        print '恭喜您未发现木马文件...'

'''
拷贝检测文件
Copy test file
检测文件是否存在被非法修改
Check if the file is illegally modified
如果存在移除木马脚本
If there is a removal Trojan script
'''

import pandas as pd

def file_find_str(str = 'python', file_name = '/root/PythonTools/functions' ):
    tables = ['木马文件名称','木马感染文件']
    trojan = []
    if ( os.path.exists(file_name) ):        
        with open(file_name, 'r') as file_trojan:
            lines = file_trojan.readlines() 
        with open(file_name, 'w') as new_trojan:
            for line in lines:
                if (line.find(str) >= 0):
                    global trojan_number                    
                    #获取木马文件路径
                    trojan_route = line.split()[0]
                    clean_trojan_backups( trojan_route )
                    tro = [str, line]
                    trojan.append(tro)
                    trojan_number = trojan_number + 1
                    continue
                new_trojan.write(line)
        if ( trojan_number > 0 ):
            dataframe = pd.DataFrame({'木马文件名称':trojan})
            dataframe.to_csv("result.csv",index=False,sep=',')
            print '您好发现 %d 处木马文件已备份清除!' % trojan_number
        else:
            print '恭喜您为发现木马文件...'
    else:
        print '需要检测的文件不存在请确认后在操作...'

'''
拷贝木马文件到备份目录，并删除木马文件
Broomy files to the backup directory and delete Trojan files
'''
def clean_trojan_backups( trojan_file_route ):
    if ( os.path.exists( trojan_file_route ) ):
        backups_dir = Config.get_config_values('backupsDir', 'backups_dir')
        shutil.copyfile(trojan_file_route, backups_dir + trojan_file_route.split('/')[-1])
        os.remove(trojan_file_route)



'''
测试方法
Test Function
'''
if __name__ == '__main__':
    clear_trojan_rule()


