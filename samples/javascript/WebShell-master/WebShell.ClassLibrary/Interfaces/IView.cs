using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace WebShell.ClassLibrary
{
    public interface IView
    {
        object GetValue(string key);
        void SetValue(string key, string name);
    }
}
