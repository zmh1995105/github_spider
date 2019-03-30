using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace WebShell.ClassLibrary
{
    [AttributeUsage(AttributeTargets.Class | AttributeTargets.Interface)]
   public class LoginRequired:Attribute
    {
        public LoginRequired()
        {
            Active = true;
        }

        public LoginRequired(bool active)
        {
            Active = active;
        }

        public string RedirectTo { get; set; }
        public bool Active { get; set; }

    }
}
