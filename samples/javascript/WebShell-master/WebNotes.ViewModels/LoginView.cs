using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace WebNote.ViewModels
{
    public class LoginView
    {
        public string Email { get; set; }
        public string Password { get; set; }
        public string InvalidPwd { get; set; }
    }
}
