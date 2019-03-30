#!/usr/bin/python
# -*- coding: UTF-8 -*-

#导入官方库文件
import sys, getopt

#导入用户认证模块
import UserAuth
import VirusLibrary

def main():
    user_token = ''
    #获取用户输入的认证码，如果没有输入校验码提示用户输入
    if len(sys.argv) < 2:
        print '请出入验证码格式为：Cmstopscan.py -u <token>'
        sys.exit()
    try:
        opts, args = getopt.getopt(sys.argv[1:], "hu:")
    except getopt.GetoptError:
        print 'Cmstopscan.py -u <token>'
        sys.exit(2)
    for opt, arg in opts:
        if opt == '-h':
            print 'Cmstopscan.py -u <token>'
            sys.exit()
        elif opt == "-u":
            user_token = arg
    #判断验证码是否正确
    u = UserAuth.user_check_code(user_token)
    if u == "200":
        VirusLibrary.clear_trojan_rule()
        #调用木马扫描文件
        #print "ok"
    else:
        print "请输入正确的验证码！"


if __name__ == '__main__':
    main()
