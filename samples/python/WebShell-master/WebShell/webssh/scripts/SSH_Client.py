#!/usr/bin/python
# ecoding=utf8
# charset :utf8
# Author:chris
#email : chris@pythoncoding.cn
import socket
import json
import paramiko
from threading import Thread
import sys
import sys


class SSH_Client:

    def __init__(self, websocker, message, open_file):
        self.websocker = websocker
        self.message = message
        self.channel = None
        self._sftp = None
        self.open_file = open_file

    def _open_file(self):
        f = open(self.open_file, 'a')
        sys.stdout = f



    def connect(self, host, user, password,  port=22, timeout=30,
                term='xterm', pty_width=80, pty_height=24):
        try:
            ssh_client = paramiko.SSHClient()
            ssh_client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
            ssh_client.connect(username=user, password=password, hostname=host, port=port, timeout=timeout)
            transport = ssh_client.get_transport()
            self.channel = transport.open_session()
            self.channel.get_pty(term=term, width=pty_width, height=pty_height)
            self.channel.invoke_shell()
            for i in range(2):
                recv = self.channel.recv(1024).decode('utf-8')
                self.message['status'] = 0
                self.message['message'] = recv
                message = json.dumps(self.message)
                self.websocker.send(message)
        except Exception as e:
            self.message['status'] = 1
            self.message['message'] = str(e)
            message = json.dumps(self.message)
            self.websocker.send(message)
            self.websocker.close()

    def resize_pty(self, cols, rows):
        self.channel.resize_pty(width=cols, height=rows)

    def django_to_ssh(self, data):
        try:
            self.channel.send(data)

            return
        except:
            self.close()

    def websocket_to_django(self):
        self._open_file()
        try:
            while True:
                data = self.channel.recv(1024).decode('utf-8')
                if not len(data):
                    return
                self.message['status'] = 0
                self.message['message'] = data
                message = json.dumps(self.message)
                sys.stdout.write(data)
                self.websocker.send(message)
        except:
            self.close()

    def sftp(self, host, user, password, port=22, timeout=30, localpath=None, remotepath=None, types=None):
        try:
            ssh_client = paramiko.SSHClient()
            ssh_client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
            ssh_client.connect(username=user, password=password, hostname=host, port=port, timeout=timeout)
            self._sftp = ssh_client.open_sftp()
            if types == 'put':
                self._sftp.put(localpath, remotepath)
            elif types == 'get':
                self._sftp.get(remotepath, localpath)
        except Exception as e:
            raise e

    def close(self):
        self.message['status'] = 1
        self.message['message'] = '关闭连接'
        message = json.dumps(self.message)
        self.websocker.send(message)
        self.channel.close()
        self.websocker.close()

    def shell(self, data):
        Thread(target=self.django_to_ssh, args=(data,)).start()
        Thread(target=self.websocket_to_django).start()


if __name__ == '__main__':
    conn = SSH_Client('a','b')
    conn.sftp('103.10.3.232', 'root', 'pQLXPX!SPI1ehe;',localpath='/Users/chris/Desktop/update.html', remotepath='/root/update.html2', types='put')



