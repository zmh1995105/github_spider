<jsp:useBean id="prop" scope="page" class="java.util.Properties" />
<%@ page import="java.io.*,java.util.*,javax.servlet.*" %>

<%!
public String getBoundary(HttpServletRequest request,Properties prop) throws ServletException,IOException{
    String boundary = null;
    Enumeration enum_ = request.getHeaderNames();
    while(enum_.hasMoreElements()){
        String header = (String)enum_.nextElement();
        String hvalue = request.getHeader(header);
        prop.setProperty((header).toLowerCase(),hvalue);
        if("content-type".equalsIgnoreCase(header) ){
            int idx = hvalue.lastIndexOf("boundary=");
            if(idx != -1 ){
                boundary= hvalue.substring(idx+9 , hvalue.length());
            }
        }
    }
    return boundary;
}

public String getFileName(String secondline){
    int len = secondline.length();
    int idx = secondline.lastIndexOf("filename=");
    if(idx == -1 ) return null;
    String filename = secondline.substring(idx+10 , len-1);
    filename = filename.replace('\\','/');
    idx = filename.lastIndexOf("/");
    idx = idx + 1;
    filename = filename.substring( idx );
    return filename;
}
%>

<%
int ROUGHSIZE = 640000;
int MAXSIZE = 10; // 10 Mega Byte
String boundary = getBoundary(request,prop);

if(boundary == null ){
    boundary = prop.getProperty("boundary"); 
}
else{
    boundary = "--"+boundary;
}
if(boundary == null ){
    out.print("<html><form name=\"test\" method=\"post\" enctype=\"multipart/form-data\"><b>sqlmap file uploader</b><br><input type=\"File\" name=\"file\"><input type=\"Submit\" value=\"Upload\" name=\"Submit\"></form></html>");
    return;
}
Long contentsize = new Long(prop.getProperty("content-length","0"));
int c;
StringWriter st = new StringWriter();
if(contentsize.longValue() < 1L ){
    return;
} 
long l = contentsize.longValue() - ROUGHSIZE; 
int KB = 1024;
int MB = 1024 * KB;
int csize = (int)(l / MB);
if(csize > MAXSIZE ){
    return;
}
ServletInputStream fin =  request.getInputStream();
int cn;
int count=0;

while((c=fin.read()) != -1 ){
    if( c == '\r') 
        break;
    st.write(c);
    count++;
}
c=fin.read();
String tboundary = st.getBuffer().toString();
tboundary=tboundary.trim();

if(! tboundary.equalsIgnoreCase(boundary) ){
    return;
}
st.close();
st = null;
st = new StringWriter();

while((c=fin.read()) != -1 ){
    if( c == '\r' ) break;
    st.write(c);
    }
c = fin.read();

String secondline = st.getBuffer().toString();
String filename = getFileName(secondline);

st.close();
st = null;
st = new StringWriter();
while((c = fin.read()) != -1 ){
    if( c == '\r' ) break;
        st.write(c);
}
c = fin.read();

fin.read(); 
fin.read();  
File newfile = null;
FileOutputStream fout =null; 
try{
    newfile = new File("WRITABLE_DIR" + "\\" + filename);
    fout = new FileOutputStream( newfile );
}
catch(Exception ex){
    out.println(ex.getMessage());
    return;
}

byte b[] = null;
while(l > 1024L){
    b = new byte[1024];
    fin.read(b,0,1024);
    fout.write(b);
    b=null;
    l -= 1024L;
}
if(l > 0){
    b = new byte[(int)l];
    fin.read(b,0,(int)l);
    fout.write(b);
}


ByteArrayOutputStream baos = new ByteArrayOutputStream();
while((c = fin.read()) != -1){
    baos.write(c);
}
String laststring = baos.toString();
int idx = laststring.indexOf(boundary);
b = baos.toByteArray();
if(idx > 2){
    fout.write(b,0,idx-2);
}
else{
    fout.close();
    newfile.delete();
    return;
}
fout.flush();
fout.close();
fin.close();

out.println("File uploaded: " + newfile);
%>
