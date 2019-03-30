using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using WebShell.Utilities.Configuration;
using WebShell.ClassLibrary;

namespace WebShell.Utilities
{
    public class Log
    {
        static ILog log = ObjectBuilder.CreateFrom(WebShellConfig.GetCommandType("logger")).Data as ILog;
        public static void Write(string context, string title, string message)
        {
            log.Write(context, title, message);
        }
    }
}
