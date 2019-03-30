using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace WebShell.ClassLibrary
{
    public interface ILocalize
    {
        string Translate(string keyword, string language);
        void AddKeyword(string keyword);
        void AddLanguage(string language);
        void SetKeywordValue(string keyword, string value, string language);
    }
}
