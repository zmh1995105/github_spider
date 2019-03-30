using System;
using System.Collections.Generic;
using System.Text;
using System.Web;
using System.Web.SessionState;
using WebShell.ClassLibrary;
using WebShell.Utilities;

namespace WebShell
{
    class ShellHandler:IHttpHandler,IRequiresSessionState
    {
       
        #region IHttpHandler Members

        public bool IsReusable
        {
            get { return false; }
        }
        
        public void ProcessRequest(HttpContext context)
        {
            try
            {
                IResult r_object = ObjectBuilder.CreateFrom(WebShellConfig.GetCommandType("dispatcher"));
                if (r_object.Success)
                {
                    if (System.Text.RegularExpressions.Regex.IsMatch(context.Request.Url.AbsolutePath, "\\w*\\.\\w+$"))
                    {
                        //TODO: normalize forbidden extensions => low
                        string strForbiddenExt = ".exe.dll.cs.config.log";
                        string strFilePath = context.Server.MapPath(context.Request.Url.AbsolutePath);
                        string strExt = System.IO.Path.GetExtension(strFilePath);
                        if (!strForbiddenExt.Contains(strExt))
                        {
                            //context.Response.Clear();
                            context.Response.ContentType = "text/" + strExt.Replace(".", "");
                            context.Response.TransmitFile(context.Server.MapPath(context.Request.Url.AbsolutePath));
                            //context.Response.Flush();
                        }
                    }
                    else
                    {
                        ICommand command = (ICommand)r_object.Data;
                        string strVirPath = context.Request.ApplicationPath;
                        string strCommand = context.Request.Url.AbsolutePath.ToLower();
                        if (strCommand.StartsWith(strVirPath.ToLower())) strCommand = strCommand.Remove(0, strVirPath.Length);
                        if (strCommand.StartsWith("/")) strCommand = strCommand.Remove(0, 1);
                        if (strCommand == string.Empty) strCommand = "home";

                        IResult result = command.Execute(strCommand);

                        if (result.Success == true)
                        {
                            context.Response.Write(result.Data);
                        }
                        else
                        {
                            //TODO: if result not succeeded so appropriate action should be taken => High Priority
                            context.Response.Write("Command Result is not trusted.");
                        }
                    }

                }
                else
                {
                    //TODO: manage response to be more meaningful  
                    context.Response.Write("Resource not found.");
                }
            }
            catch (Exception ex)
            {
                //TODO: Redirect to Error Page -> High
                context.Response.Write("Website error");
                WebShell.Utilities.Log.Write(this.ToString(), "handler error", ex.StackTrace);
                throw ex;
            }
        }

        #endregion
    }
}
