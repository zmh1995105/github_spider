package com.xiecy.webshell.config;


import java.util.Arrays;
import java.util.Date;

import org.springframework.stereotype.Component;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.socket.CloseStatus;
import org.springframework.web.socket.TextMessage;
import org.springframework.web.socket.WebSocketMessage;
import org.springframework.web.socket.WebSocketSession;
import org.springframework.web.socket.handler.TextWebSocketHandler;

/**
 * @Auther: xiecy
 * @Date: 2018/10/30 22:36
 * @Description:ws处理类
 */
//@RequestMapping("/webshh/sshShellHandler")
@Component
public class SshShellHandler extends TextWebSocketHandler{

    //客户端
    SshClient client = null;

    //关闭连接后的处理
    @Override
    public void afterConnectionClosed(WebSocketSession session, CloseStatus status) throws Exception {
        // TODO Auto-generated method stub
        super.afterConnectionClosed(session, status);

        //关闭连接
        if (client != null) {
            client.disconnect();
        }
    }

    //建立socket连接
    @Override
    public void afterConnectionEstablished(WebSocketSession session) throws Exception {
        // TODO Auto-generated method stub
        super.afterConnectionEstablished(session);
        //做多个用户处理的时候，可以在这个地方来 ,判断用户id和
        //配置服务器信息
        Server server = new Server("","","");

        //初始化客户端
        client = new SshClient(server, session);

        //连接服务器
        client.connect();
    }

    //处理socker发送过来的消息
    @Override
    public void handleMessage(WebSocketSession session, WebSocketMessage<?> message) throws Exception {
        super.handleMessage(session, message);

        //处理连接
        try {
            TextMessage msg = (TextMessage) message;
            //当客户端不为空的情况
            if (client != null) {
                //receive a close cmd ?
                if (Arrays.equals("exit".getBytes(), msg.asBytes())) {

                    if (client != null) {
                        client.disconnect();
                    }

                    session.close();
                    return ;
                }
                //写入前台传递过来的命令，发送到目标服务器上
                client.write(new String(msg.asBytes(), "UTF-8"));
            }
        } catch (Exception e) {
            e.printStackTrace();
            session.sendMessage(new TextMessage("An error occured, websocket is closed."));
            session.close();
        }
    }
}

