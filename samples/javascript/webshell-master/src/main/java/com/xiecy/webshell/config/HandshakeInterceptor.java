package com.xiecy.webshell.config;


import java.util.Map;


import org.springframework.http.server.ServerHttpRequest;
import org.springframework.http.server.ServerHttpResponse;
import org.springframework.http.server.ServletServerHttpRequest;
import org.springframework.web.socket.WebSocketHandler;
import org.springframework.web.socket.server.support.HttpSessionHandshakeInterceptor;

import javax.servlet.http.HttpSession;



/**
 * @Auther: xiecy
 * @Date: 2018/10/30 22:37
 * @Description:创建握手，类似与http的连接 三次握手一次挥手
 */
public class HandshakeInterceptor extends HttpSessionHandshakeInterceptor{

    @Override
    public void afterHandshake(ServerHttpRequest request, ServerHttpResponse response, WebSocketHandler wsHandler,
                               Exception ex) {
        super.afterHandshake(request, response, wsHandler, ex);
    }

    @Override
    public boolean beforeHandshake(ServerHttpRequest arg0, ServerHttpResponse request, WebSocketHandler arg2,
                                   Map<String, Object> attr) throws Exception {

        return super.beforeHandshake(arg0, request, arg2, attr);
    }

}
