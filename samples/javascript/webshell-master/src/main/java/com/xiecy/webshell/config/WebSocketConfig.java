package com.xiecy.webshell.config;



import org.springframework.context.annotation.Configuration;

import org.springframework.web.socket.config.annotation.EnableWebSocket;
import org.springframework.web.socket.config.annotation.WebSocketConfigurer;
import org.springframework.web.socket.config.annotation.WebSocketHandlerRegistry;
/**
 * @Auther: xiecy
 * @Date: 2018/10/30 22:38
 * @Description:
 */
@Configuration
@EnableWebSocket
public class WebSocketConfig implements WebSocketConfigurer {

    @Override
    public void registerWebSocketHandlers(WebSocketHandlerRegistry registry) {
        //支持websocket
        registry.addHandler(new SshShellHandler(), "/websocket/test2").addInterceptors(new HandshakeInterceptor()).setAllowedOrigins("http://localhost:12999");
        //支持sockjs
//        registry.addHandler(new SshShellHandler(), "/websocket/test2").addInterceptors(new HandshakeInterceptor()).withSockJS();
    }
}