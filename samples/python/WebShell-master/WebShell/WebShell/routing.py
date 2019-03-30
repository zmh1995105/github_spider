#!/usr/bin/python
# ecoding=utf8
# charset :utf8
# Author:chris
#email : chris@pythoncoding.cn
from channels.auth import AuthMiddlewareStack
from channels.routing import ProtocolTypeRouter, URLRouter
from webssh.scripts import routing

application = ProtocolTypeRouter({
    'websocket': AuthMiddlewareStack(
        URLRouter(
            routing.websocket_urlpatterns
        )
    ),
})