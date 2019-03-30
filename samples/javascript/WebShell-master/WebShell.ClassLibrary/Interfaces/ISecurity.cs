using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace WebShell.ClassLibrary
{
   public  interface ISecurity
    {
       bool IsValidUser();
       bool IsValidRole();
       IResult Login(string ReturnCommandName);
    }
}
