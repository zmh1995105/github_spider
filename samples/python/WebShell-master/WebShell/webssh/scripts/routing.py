#!/usr/bin/python
# ecoding=utf8
# charset :utf8
# Author:chris
#email : chris@pythoncoding.cn
from django.urls import path
from webssh.scripts.WebSSH import WebSSH

websocket_urlpatterns = [
    path('webssh/', WebSSH),
]