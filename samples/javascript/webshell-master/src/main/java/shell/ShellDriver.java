package shell;

import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;

import com.jcraft.jsch.Channel;
import com.jcraft.jsch.JSch;
import com.jcraft.jsch.Session;
import com.jcraft.jsch.UserInfo;

/**
 * @author chengjin.lyf on 2018/4/17 下午3:41
 * @since 3.2.6
 */
public class ShellDriver implements AutoCloseable {

    private String user;
    private String passwd;
    private String host;
    private int port;
    private JSch jSch;

    private OutputStream os;

    private InputStream is;

    private Session session;

    private Channel channel;

    public ShellDriver(String user, String passwd, String host, int port){
        this.user = user;
        this.passwd = passwd;
        this.host = host;
        this.port = port;
        jSch = new JSch();
    }

    public void connect(IReaderHandler handler) throws Exception {
        session = jSch.getSession(user, host, port);
        session.setPassword(passwd);
        UserInfo userInfo = new UserInfo() {

            @Override
            public String getPassphrase() {
                System.out.println("getPassphrase");
                return null;
            }

            @Override
            public String getPassword() {
                System.out.println("getPassword");
                return null;
            }

            @Override
            public boolean promptPassword(String s) {
                System.out.println("promptPassword:" + s);
                return false;
            }

            @Override
            public boolean promptPassphrase(String s) {
                System.out.println("promptPassphrase:" + s);
                return false;
            }

            @Override
            public boolean promptYesNo(String s) {
                System.out.println("promptYesNo:" + s);
                return true;// notice here!
            }

            @Override
            public void showMessage(String s) {
                System.out.println("showMessage:" + s);
            }
        };

        session.setUserInfo(userInfo);

        session.connect(30000); // making a connection with timeout.
        channel = session.openChannel("shell");
        InputStream inputStream = channel.getInputStream();
        OutputStream outputStream = channel.getOutputStream();
        os = outputStream;
        is = inputStream;
        channel.connect(3 * 1000);
        Thread t = new Thread(() -> {
            System.out.println("read ssh thread start!");
            byte[] bytes = new byte[512];
            int len = -1;
            try{
                while ((len = is.read(bytes))!= -1){
                    byte[] b = new byte[len];
                    System.arraycopy(bytes, 0, b, 0, len);
                    handler.onRead(b, len);
                }
            }catch (Exception e){
            }
            System.out.println("read ssh thread stop!");
        });
        t.setDaemon(true);
        t.start();
    }

    public void write(byte[] data) throws IOException {
        os.write(data);
        os.flush();
    }

    public interface IReaderHandler {

        void onRead(byte []data, int len);
    }

    @Override
    public void close() throws Exception {
        if (is != null)
            is.close();
        if (os != null)
            os.close();
    }
}
