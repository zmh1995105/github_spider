#!/usr/bin/python
# ecoding=utf8
# charset :utf8
# Author:chris
#email : chris@pythoncoding.cn
from channels.generic.websocket import WebsocketConsumer
from webssh.scripts.SSH_Client import SSH_Client
from django.http.request import QueryDict
from django.utils.six import StringIO
import json
import base64
import uuid
from webssh.models import Webshell_Audit
import  datetime
import sys
import base64

class WebSSH(WebsocketConsumer):
    message = {'status': 0, 'message': None}
    """
    status:
        0: ssh 连接正常, websocket 正常
        1: 发生未知错误, 关闭 ssh 和 websocket 连接

    message:
        status 为 1 时, message 为具体的错误信息
        status 为 0 时, message 为 ssh 返回的数据, 前端页面将获取 ssh 返回的数据并写入终端页面
    """

    def connect(self):
        try:
            self.accept()
            query_string = self.scope['query_string']
            connet_argv = QueryDict(query_string=query_string, encoding='utf-8')
            width = connet_argv.get('width')
            height = connet_argv.get('height')
            op_user = connet_argv.get('op_user')
            op_ip = connet_argv.get('op_ip')

            host_ip = connet_argv.get('host')
            user = connet_argv.get('user')
            password = connet_argv.get('password')
            log_file_name = 'attachment/{}.log'.format(uuid.uuid1())

            password = base64.b64decode(password.encode('utf-8'))

            # host_ip = '103.10.3.232'
            # user = 'root'
            # password = 'pQLXPX!SPI1ehe;'
            print(host_ip, user, password)
            audit = Webshell_Audit()
            audit.host_ip = host_ip
            audit.op_ip = op_ip
            audit.op_user = op_user
            audit.log = log_file_name
            audit.insert_time = datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S")
            audit.save(force_insert=True)

            width = int(width)
            height = int(height)
            self.ssh = SSH_Client(websocker=self, message=self.message, open_file=log_file_name)

            self.ssh.connect(
                host=host_ip,
                user=user,
                password=password.decode('utf8'),
                port=22,
                pty_width=width,
                pty_height=height
            )

        except Exception as e:
            self.message['status'] = 1
            self.message['message'] = str(e)
            message = json.dumps(self.message)
            self.send(message)
            self.close()

    def disconnect(self, close_code):
        try:
            self.ssh.close()
        except:
            pass

    def receive(self, text_data=None, bytes_data=None):
        data = json.loads(text_data)
        if type(data) == dict:
            status = data['status']
            if status == 0:
                data = data['data']
                self.ssh.shell(data)
            else:
                cols = data['cols']
                rows = data['rows']
                self.ssh.resize_pty(cols=cols, rows=rows)