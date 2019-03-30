using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using WebNote.ViewModels;
using WebShell.ClassLibrary;
using WebShell.Utilities;
using System.Web;
using System.Reflection;
using WebNote.DB.Business;
using System.IO;

namespace WebNote.Notes
{
    [LoginRequired(Active=false)]
    class HomeCommand:NoteCommand
    {
        public IResult GET()
        {
            IResult result = new Result();
            HttpContext.Current.Session["activeMI"] = "public_notes";
            result = presenter.GetViewHTML("home.htm");

            return result;
        }

        public IResult POST()
        {
            IResult result = new Result();
            dynamic view = new NoteSearchView();
            presenter.SetViewModel(view, HttpContext.Current.Request);
            view.Notes = WebNote.DB.Business.WebNoteBiz.SearchNotes(view.Query);
            result = presenter.GetViewHTML("Search.htm", view);
            return result;
        }
    }
}
