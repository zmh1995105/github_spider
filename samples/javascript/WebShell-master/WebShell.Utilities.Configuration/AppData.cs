using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Web;

namespace WebShell.Utilities
{
   public class AppData
    {
       static string baseUrl=string.Empty;
       public static string GetBaseUrl()
       {
           if (baseUrl != string.Empty)
               return baseUrl;
           else
           {
               baseUrl  = HttpContext.Current.Request.Url.AbsoluteUri.Replace(HttpContext.Current.Request.Url.PathAndQuery, "");
               baseUrl += HttpContext.Current.Request.ApplicationPath+"/";
               return baseUrl;
           }
       }
    }
}
