using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace WebShell.Utilities
{
    public static class User
    {
        public static long Id
        {
            get
            {
                if (System.Web.HttpContext.Current.Session["UserId"] == null) return -1;
                else return long.Parse(System.Web.HttpContext.Current.Session["userId"].ToString());
            }
            set
            {
                System.Web.HttpContext.Current.Session["UserId"] = value;
            }
        }
        public static string Email
        {
            get
            {
                if (System.Web.HttpContext.Current.Session["Email"] == null) return string.Empty;
                else return System.Web.HttpContext.Current.Session["Email"].ToString();
            }
            set
            {
                System.Web.HttpContext.Current.Session["Email"] = value;
            }
        }
    }
}
