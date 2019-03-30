package com.ws;

import java.io.*;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

public class Download extends HttpServlet {

    protected void processRequest(HttpServletRequest request, HttpServletResponse response) throws IOException 
            
    {
        String path = request.getParameter("f");
        if (path == null) {
            response.setContentType("text/html;charset=UTF-8");
            PrintWriter out = response.getWriter();
            out.println("<html>");
            out.println("<head>");
            out.println("<title>Download</title>");
            out.println("</head>");
            out.println("<body>");
            out.println("<form action=\"DTest\" method=\"POST\">");
            out.println("<input name=\"f\" value=\"\"/>");
            out.println("<input type=\"submit\" name=\"submit\" value=\"Download\"/>");
            out.println("</form>");
            out.println("</body>");
            out.println("</html>");
            out.close();

        } else {
            File file = new File(path);

            response.setContentType("text/plain");
            response.setHeader("Content-Disposition",
                    "attachment;filename=" + file.getName());
            OutputStream os = response.getOutputStream();
            try {
                InputStream is = new FileInputStream(file);

                int read;
                byte[] bytes = new byte[10000];
                while ((read = is.read(bytes)) != -1) {
                    os.write(bytes, 0, read);
                }
            } catch (Exception e) {
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
        return "blah DTest";
    }// </editor-fold>
}
