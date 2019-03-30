package me.hupeng.webshell.servlet;

import java.io.IOException;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;


@WebServlet("/index.html")
public class IndexServlet extends HttpServlet{

	@Override
	protected void doGet(HttpServletRequest req, HttpServletResponse resp)
			throws ServletException, IOException {
		// TODO Auto-generated method stub
		//super.doGet(req, resp);
		req.setCharacterEncoding("utf-8");
		resp.setCharacterEncoding("utf-8");
		req.getRequestDispatcher("jsp/index.jsp").forward(req, resp);
	}
	
}
