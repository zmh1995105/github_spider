using System;
using System.Collections.Generic;
using System.Text;
using System.Web;

namespace WebShell.ClassLibrary
{
    public interface IPresenter
    {
        void SetViewModel(dynamic viewType, HttpRequest httpRequest=null);
        IResult GetViewHTML(string resourceName, dynamic viewType=null);
        IResult Localize(string resourceName);

    }
}

