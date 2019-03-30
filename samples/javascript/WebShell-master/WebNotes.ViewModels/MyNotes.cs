using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using WebShell.ClassLibrary;

namespace WebNote.ViewModels
{
    public class MyNotes:IView
    {
        private Dictionary<string, string> ExtraVars = new Dictionary<string, string>();
        public string Notes { get; set; }

        #region IView Members

        public object GetValue(string key)
        {
            if (ExtraVars.ContainsKey(key))
                return ExtraVars[key];
            else return null;
        }

        public void SetValue(string key, string value)
        {
            if (ExtraVars.ContainsKey(key)) ExtraVars[key] = value;
            else ExtraVars.Add(key, value);
        }

        #endregion
    }
}
