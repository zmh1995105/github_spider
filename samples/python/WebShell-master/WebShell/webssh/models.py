#!/usr/bin/python
# ecoding=utf8
# charset :utf8
# Author:chris
#email : chris@pythoncoding.cn
from django.db import models

class Webshell_Audit(models.Model):
    """
    webshell审计信息记录表
    """
    host_ip = models.CharField('host_ip', max_length=200, null=False) #服务器ip
    op_user = models.CharField('op_user', max_length=200, null=False) #操作用户
    op_ip = models.CharField('op_ip', max_length=200, null=False) #操作用户ip
    log = models.CharField('log', max_length=200, null=False) #操作日志位置
    insert_time = models.CharField('insert_time', max_length=200, null=False) #操作时间