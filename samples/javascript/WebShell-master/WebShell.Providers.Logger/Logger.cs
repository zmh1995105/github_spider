using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.IO;
using System.Web;
using WebShell.ClassLibrary;

namespace WebShell.Providers.Log
{
    public class Logger:ILog
    {
        public Logger()
        {
            if (!Directory.Exists(HttpContext.Current.Request.PhysicalApplicationPath + "WS_Logs"))
                Directory.CreateDirectory(HttpContext.Current.Request.PhysicalApplicationPath + "WS_Logs");
        }

        public void Write(string context, string title, string message)
        {
            
            string strLogFile = HttpContext.Current.Request.PhysicalApplicationPath
                + "WS_LOGS\\"
                + context
                + DateTime.Now.ToString("dd-MM-yyyy")
                + ".log";
            string strLogText = "["+title+"] " + DateTime.Now.ToString()
                + "\r\n----------------------------------------------------------------- \r\n";
            strLogText += message + "\r\n----------------------------------------------------------------- \r\n";
            if (!File.Exists(strLogFile))
            {
                File.WriteAllText(strLogFile, strLogText);
            }
            else
            {
                File.AppendAllText(strLogFile, strLogText);
            }
        }
    }
}
