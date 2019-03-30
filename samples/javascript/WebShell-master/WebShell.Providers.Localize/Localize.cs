using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using WebShell.ClassLibrary;

namespace WebShell.Providers.Localize
{
    public class Localize:ILocalize
    {
        #region ILocalize Members

        public string Translate(string keyword, string language)
        {
            throw new NotImplementedException();
        }

        public void AddKeyword(string keyword)
        {
            throw new NotImplementedException();
        }

        public void AddLanguage(string language)
        {
            throw new NotImplementedException();
        }

        public void SetKeywordValue(string keyword, string value, string language)
        {
            throw new NotImplementedException();
        }

        #endregion
    }
}
