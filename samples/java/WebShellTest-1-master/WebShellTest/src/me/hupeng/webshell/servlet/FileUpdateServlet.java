package me.hupeng.webshell.servlet;

import java.io.File;
import java.io.IOException;
import java.util.Iterator;
import java.util.List;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import org.apache.commons.fileupload.FileItem;
import org.apache.commons.fileupload.disk.DiskFileItemFactory;
import org.apache.commons.fileupload.servlet.ServletFileUpload;

@WebServlet("/fileUpload")
public class FileUpdateServlet extends HttpServlet {

	@Override
	protected void doPost(HttpServletRequest request,
			HttpServletResponse response) throws ServletException, IOException {
		// TODO Auto-generated method stub
		request.setCharacterEncoding("UTF-8");
		response.setCharacterEncoding("UTF-8");
		// 用于存放输出的信息
		String message = "";

		// 在自己的项目中构造出一个用于存放用户照片的文件夹
		String defaultField = "uploadFiles";
		String projectpath = this.getServletContext().getRealPath(
				"/" + defaultField + "/");
		// 如果此文件夹不存在，则构造此文件夹
		File f = new File(projectpath);
		if (!f.exists()) {
			f.mkdir();
		}
		// 构造出文件工厂，用于存放JSP页面中传递过来的文件
		DiskFileItemFactory factory = new DiskFileItemFactory();
		// 设置缓存大小，如果文件大于缓存大小时，则先把文件放到缓存中
		factory.setSizeThreshold(4 * 1024);
		// 设置上传文件的保存路径
		factory.setRepository(f);

		// 产生Servlet上传对象
		ServletFileUpload upload = new ServletFileUpload(factory);
		// 设置可以上传文件大小的上界10MB
		upload.setSizeMax(10 * 1024 * 1024);

		try {
			// 取得所有上传文件的信息
			List<FileItem> list = upload.parseRequest(request);
			Iterator<FileItem> iter = list.iterator();
			while (iter.hasNext()) {
				FileItem item = iter.next();
				// 如果接收到的参数不是一个普通表单(例text等)的元素，那么执行下面代码
				if (!item.isFormField()) {
					String fieldName = item.getFieldName();// 获得此表单元素的name属性
					String fileName = item.getName();// 获得文件的完整路径
					String contentType = item.getContentType();// 获得文件类型
					long fileSize = item.getSize();// 获得文件大小
					// 从文件的完整路径中截取出文件名
					// 获取扩展名
					String extFile = fileName.split("\\.")[fileName.split("\\.").length - 1];
					fileName = fieldName + "." + extFile;
					File uploadedFile = new File(projectpath, fileName);

					try {
						// 如果在该文件夹中已经有相同的文件，那么将其删除之后再重新创建（只适用于上传一张照片的情况）
						if (uploadedFile.exists()) {
							uploadedFile.delete();
						}

						item.write(uploadedFile);

					} catch (Exception e) {
						e.printStackTrace();
						// return ;
					}

				} else {
					message = "<h3>文件未选择或文件路径不合法，请检查</h3>";
					// 取得普通的对象（对于像文本框这种类型的使用）
					// 对于普通类型的对象暂不做处理
					// return ;
				}
			}

		} catch (Exception e) {
			// TODO Auto-generated catch block
			message = "上传失败";
			e.printStackTrace();
		}

		request.setAttribute("message", message);
		request.getRequestDispatcher("jsp/uploadResult.jsp").forward(request,
				response);
	}

	@Override
	protected void doGet(HttpServletRequest req, HttpServletResponse resp)
			throws ServletException, IOException {
		// TODO Auto-generated method stub
		req.setCharacterEncoding("UTF-8");
		resp.setCharacterEncoding("UTF-8");
		resp.getOutputStream().write("来自HUPENG的问候，get请求不允许,哈哈哈哈".getBytes());
	}

}
