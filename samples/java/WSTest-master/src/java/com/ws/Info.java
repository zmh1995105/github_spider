package com.ws;

import java.io.IOException;
import java.io.PrintWriter;
import java.util.Enumeration;
import java.util.Iterator;
import java.util.Map;
import java.util.Properties;
import java.util.Set;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

public class Info extends HttpServlet {

    protected void processRequest(HttpServletRequest request, HttpServletResponse response)
            throws IOException 
    {
        response.setContentType("text/html;charset=UTF-8");

        PrintWriter out = response.getWriter();

        out.println("<html>");
        out.println("<head>");
        out.println("<title>Info Servlet</title>");
        out.println("</head>");
        out.println("<body>");
        out.println("Context Path: " + request.getContextPath());
        out.println("<br>");
        out.println("Servlet Path: " + request.getServletPath());
        out.println("<br>");
        out.println("Local: "
                + request.getLocalAddr() + ":" + request.getLocalPort() + " ("
                + request.getLocalName() + ")");
        out.println("<br>");
        out.println("Remote: "
                + request.getRemoteAddr() + ":" + request.getRemotePort() + " ("
                + request.getRemoteHost() + ")");
        out.println("<br><br>");
        out.println("System Properties:<br>");
        Properties props = System.getProperties();
        Enumeration e = props.propertyNames();
        while (e.hasMoreElements()) {
            String key = (String) e.nextElement();
            out.println(key + " = " + props.getProperty(key));
            out.println("<br>");
        }
        out.println("<br>");
        out.println("Environment:<br>");
        Map env = System.getenv();
        Iterator it = env.keySet().iterator();
        while (it.hasNext()) {
            String key = (String) it.next();
            out.println(key + "=" + env.get(key));
            out.println("<br>");
        }
        out.println("<br>");
        out.println("</body>");
        out.println("</html>");
        out.close();
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
        return "blah ITest";
    }// </editor-fold>
}
