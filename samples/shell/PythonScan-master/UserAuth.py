#!/usr/bin/python
# -*- coding: UTF-8 -*- 

'''
Author: stone
Time: 2018-08-09 15:30
Describe: 用户认证模块
'''

'''
引入官方库文件
Introducing the official library file
'''
import urlparse

'''
引入本地库文件
Introducing local library files
'''
import Config
import Http

'''
判断用户校验码是否正确
Determine if the user check code is correct
'''
def user_check_code( token ) :
    url = Config.get_config_values('usertoken', 'url')
    urlToken = urlparse.urljoin(url, token)
    res = Http.http_post( urlToken  )
    return res

'''
测试方法
Test function
'''
if __name__ == '__main__':
    print_func('PIWJTDQxx0HKwKUQeZIqTbKL')


