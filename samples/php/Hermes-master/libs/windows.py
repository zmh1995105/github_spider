# _*_ coding: utf-8 _*_
#
# @function: scanner for windows system
# @author: Alvin
# @create time: 2018.2.7

import getopt
import os
import socket
import sys
import subprocess
import re
import time
import urllib
import urllib2

# 设置白名单
pass_file = ["api_ucenter.php"]

# 记录报告的服务器地址
req_url = 'test'

RULE_LIST = [
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


def send_report(ip, hostname, file_path, rule, describe):

    try:
        req_data = {
            'ip': ip,
            'hostname': hostname,
            'file_path': file_path,
            'rule': rule,
            'describe': describe
        }

        req = urllib2.Request(url=req_url, data=urllib.urlencode(req_data))
        res_data = urllib2.urlopen(req)
        return res_data.read()

    except:
        print "Send report failed!"
        return False


class WindowsScan:

    def __init__(self, tg, un, pw):
        self.target = tg
        self.username = un
        self.password = pw

    def _get_ip_list(self):
        ip_list = []
        with open(self.target, 'r') as f:
            for line in f.readlines():
                cur_ip = line[:-1] if line[-1] in ('\n', '\r\n') else line
                ip_list.append(cur_ip)
        return ip_list

    def _login(self, ip):
        # tmp = subprocess.call(r'net use \\%s\ipc$ "password" /user:noahwm\username' % ip)
        login_str = r'net use \\%s\ipc$ "%s" /user:%s' % (ip, self.password, self.username)
        print login_str
        tmp = subprocess.call(login_str)
        if tmp == 0:
            sys.stdout.write("Damon use login success! \n")
            return True
        else:
            sys.stdout.write("Damon use login failed! Please retry or change the target IP\n")
            return False

    @staticmethod
    def _logout(ip):
        subprocess.call(r'net use \\%s\ipc$ /delete' % ip)

    def _scan(self, path, ip):
        print "Start scan from " + path
        for root, dirs, files in os.walk(path):
            for filespath in files:
                if '.' in filespath:
                    ext = filespath[(filespath.rindex('.') + 1):]
                    # print ext
                    if ext in ['jsp', 'jspx', 'php', 'aspx', 'asp', 'cer', 'asa', 'ashx', 'do']:
                        # print ext
                        if filespath not in pass_file:
                            file = open(os.path.join(root, filespath))
                            filestr = file.read()
                            file.close()
                            for rule in RULE_LIST:
                                result = re.compile(rule).findall(filestr)
                                if result:

                                    a = 'Found_File: ' + os.path.join(root, filespath) + '\n'
                                    b = 'Webshell_Rule: ' + str(result[0]) + '\n'
                                    c = 'File_Of_Time: ' + time.strftime('%Y-%m-%d %H:%M:%S', time.localtime(
                                        os.path.getmtime(os.path.join(root, filespath)))) + '\n'
                                    d = '\n\n'
                                    print a, b, c

                                    try:
                                        hostname = socket.gethostbyaddr(ip)[0]
                                    except:
                                        hostname = 'null'
                                    target_ip = ip
                                    file_path = os.path.join(root, filespath)
                                    rule = str(result[0])

                                    # check file size, if size > 500k, don't save file content
                                    if len(filestr) / 1024 > 500:
                                        describe = ''
                                    else:
                                        describe = filestr

                                    if send_report(target_ip, hostname, file_path, rule, describe):
                                        print "Send report success!\n\n"
                                    else:
                                        print "Send report failed!\n\n"

                                    with open(ip + '.txt', 'a') as f:
                                        f.write(a + b + c + d)
                                    break

    def start(self):
        ip_list = self._get_ip_list()
        for ip in ip_list:
            start = time.time()
            print '--------------------Scan Begin %s-----------------------------------' % ip

            # first: login
            if not self._login(ip):
                print "Please check the username and password is right or not"
                send_report(ip, 'login_failed', 'login_failed', 'login_failed', 'login_failed')
                continue
            print "Please don't close the command windows, Scanning....."

            # second: scan
            root_list = [r'\\%s\c$' % ip, r'\\%s\d$' % ip, r'\\%s\e$' % ip]
            for root in root_list:
                try:
                    self._scan(root, ip)
                except:
                    continue

            # third: logout
            self._logout(ip)

            print '--------------------Scan Done------------------------------------'
            spend_time = time.time() - start
            print "Spend time(min): " + str(int(spend_time)/60)


def main(argv):
    scripts_name = os.path.basename(__file__)

    target = u''
    username = u''
    password = u''

    try:
        opts, args = getopt.getopt(argv, "ht:u:p:", ["tg=", "un=", "pw="])
    except getopt.GetoptError:
        sys.stdout.write('python %s -u <username> -p <password> -t <ip list file(ex: ips.txt)>\n' % scripts_name)
        sys.stdout.write('python %s -u NOAHWMTEST\www111 -p password -t ips.txt\n' % scripts_name)
        sys.stdout.write('Please enter the full information by this format!\n')
        sys.exit(2)

    for opt, arg in opts:
        if opt == '-h':
            sys.stdout.write('python %s -u <username> -p <password> -t <ip list file(ex: ips.txt)>\n' % scripts_name)
            sys.stdout.write('python %s -u NOAHWMTEST\www111 -p password -t ips.txt\n' % scripts_name)
            sys.exit()

        elif opt in ("-t", "--target"):
            target = arg
            if not os.path.isfile(target):
                sys.stdout.write('Please enter check the target file exist or not!')
                sys.exit()
        elif opt in ("-u", "--username"):
            username = arg
        elif opt in ("-p", "--password"):
            password = arg

    if (not target) or (not username) or (not password):
        sys.stdout.write('python %s -u <username> -p <password> -t <ip list file(ex: ips.txt)>\n' % scripts_name)
        sys.stdout.write('python %s -u NOAHWMTEST\www111 -p password -t ips.txt\n' % scripts_name)
        sys.stdout.write('Please enter the full information by this format!\n')
        sys.exit(2)

    print u"记录目标IP的文件：", target
    print u"用户名：", username
    print u"密码：******"
    scanner = WindowsScan(target, username, password)
    scanner.start()


if __name__ == '__main__':
    main(sys.argv[1:])


