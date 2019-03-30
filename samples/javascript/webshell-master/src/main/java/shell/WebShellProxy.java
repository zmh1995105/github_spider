package shell;

import io.vertx.core.Vertx;
import io.vertx.core.buffer.Buffer;
import io.vertx.core.http.HttpServer;
import io.vertx.core.http.ServerWebSocket;
import io.vertx.ext.web.Router;
import io.vertx.ext.web.handler.StaticHandler;

import java.io.IOException;

/**
 * @author chengjin.lyf on 2018/4/17 下午2:01
 * @since 3.2.6
 */
public class WebShellProxy {


    public static void initHttpServer(Vertx vertx){
        HttpServer httpServer = vertx.createHttpServer();
        Router router = Router.router(vertx);
        router.route("/*").handler(StaticHandler.create().setWebRoot("webRoot").setIndexPage("index.html"));
        router.route("/shell").handler(routingContext -> {
            ServerWebSocket socket = routingContext.request().upgrade();
            ShellDriver shellDriver = new ShellDriver("root", "123456", "10.211.55.5", 22);
            System.out.println("innit shell driver");
            try {
                shellDriver.connect((data, len) ->{
                    socket.writeFinalBinaryFrame(Buffer.buffer(data));
                });
            } catch (Exception e) {
                e.printStackTrace();
            }
            socket.handler(buffer -> {
                try {
                    shellDriver.write(buffer.getBytes());
                } catch (IOException e) {
                    e.printStackTrace();
                }
            });
        });



        httpServer.requestHandler(router::accept).
                listen(3000, res -> {
                    if(!res.succeeded()){
                        res.cause().printStackTrace();
                        System.exit(0);
                    }
                });
    }




    public static void main(String args[]){
        Vertx vertx = Vertx.factory.vertx();
        initHttpServer(vertx);
    }
}
