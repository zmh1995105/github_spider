using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using WebShell.ClassLibrary;

namespace WebNote.ViewModels
{
   public class NoteView:IView
    {
       public Dictionary<string, string> ExtraVars = new Dictionary<string, string>();

       public long NoteId { get; set; }
       public string Title { get; set; }
       public string IsPublic { get; set; }
       public string NoteText { get; set; }
       public string Note { get; set; }
       public string Tag { get; set; }

       #region IView Members

       public object GetValue(string key)
       {
           return ExtraVars[key];
       }

       public void SetValue(string key, string value)
       {
           if (ExtraVars.ContainsKey(key)) ExtraVars[key] = value;
           else ExtraVars.Add(key, value);
       }

       #endregion
    }
}
