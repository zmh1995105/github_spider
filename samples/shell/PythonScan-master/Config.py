#!/usr/bin/python
# -*- coding: UTF-8 -*-

'''
引入官方库文件
Introducing the official libray file
'''
import os
import configparser

'''
获取当前项目路径
Get the current project path
'''
rootdir = os.path.split(os.path.realpath(__file__))[0]

'''
获取配置文件
Take configuration file
'''
configFilePath = os.path.join(rootdir, 'config.ini')

'''
根据传入的section获取对应的value
Get the corresponding value according to the incoming section
Section: ini配置文件中用[]标识的内容
Section: the content identified by [] in the ini configuration file
'''
def get_config_values(section, option):
    config = configparser.ConfigParser()
    config.read(configFilePath)
    return config.get(section=section, option=option)

'''
测试方法
Test function
'''
if __name__ == '__main__':
    result = get_config_values('userinfo', 'url')
    print(result)




