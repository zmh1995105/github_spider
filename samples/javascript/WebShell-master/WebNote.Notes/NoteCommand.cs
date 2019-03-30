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
using WebNote.DB.Business;

namespace WebNote.Notes
{
    [LoginRequired()]
    class NoteCommand:ICommand
    {
        static protected IPresenter presenter = ObjectBuilder.CreateFrom(WebShellConfig.GetCommandType("presenter")).Data as IPresenter;
        #region ICommand Members

        public IResult Execute(string command)
        {
            IResult result = new Result();
            string strCommandName = GetCommand(command);
            string strMethodName;
            if (strCommandName == string.Empty) strMethodName = HttpContext.Current.Request.HttpMethod.ToLower();
            else
                strMethodName = strCommandName.ToLower() + "_" + HttpContext.Current.Request.HttpMethod.ToLower();
            MethodInfo mi = ObjectBuilder.GetMethodInfo(this, strMethodName);           
            result= mi.Invoke(this, null) as IResult;
            return result;
        }

        public string GetCommand(string command)
        {
            string strCommandName = command.ToLower();
            if (strCommandName.StartsWith("/"))
            {
                strCommandName = strCommandName.Remove(0, 1);
            }
            if (strCommandName != string.Empty) strCommandName = strCommandName.Split('/')[0];
            else strCommandName = string.Empty;

            return strCommandName;
        }
        #endregion

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
            dynamic view = new NoteView();
            presenter.SetViewModel( view, HttpContext.Current.Request);

            return result;
        }

        public IResult Add_GET()
        {
            IResult result = new Result();
            HttpContext.Current.Session["activeMI"] = "add_note";
            result = presenter.GetViewHTML("AddNote.htm");

            return result;
        }

        public void Add_POST()
        {
            HttpContext.Current.Session["activeMI"] = "add_note";
            dynamic view = new NoteView();
            HttpRequest httprequest = HttpContext.Current.Request;

            presenter.SetViewModel(view);
            //handel checkbox value
            //TODO: refine presenter setview to handel this case internaly and return true or false for checkboxes => medium
            bool isPublic = false;
            if (view.IsPublic == null) isPublic = false;
            else if (view.IsPublic.ToLower() == "on") isPublic = true;
            if (WebNoteBiz.AdNote(WebShell.Utilities.User.Id, view.Title, isPublic, view.Tag, view.NoteText))
            {
                //TODO: chnge url to MyNotes
                HttpContext.Current.Response.Redirect(AppData.GetBaseUrl());
            }
            else
            {
                HttpContext.Current.Response.Redirect(HttpContext.Current.Request.Url.AbsolutePath + "/security/login/?e=il");
            }
        }

        IResult Edit_GET()
        {
            IResult result = new Result();
            dynamic view = new NoteView();
            long id = long.Parse(HttpContext.Current.Request.QueryString["id"].ToString());
            string strJsonData = WebNoteBiz.GetNote(id);
            result.Data = strJsonData;
            result.Success = true;
            return result;
        }

        IResult Edit_POST()
        {
            IResult result = new Result();
            dynamic view = new NoteView();
            presenter.SetViewModel(view);
            //handel checkbox value
            //TODO: refine presenter setview to handel this case internaly and return true or false for checkboxes => medium
            bool isPublic = false;
            if (view.IsPublic == null) isPublic = false;
            else if (view.IsPublic.ToLower() == "on") isPublic = true;
            if (WebNoteBiz.EditNote(view.NoteId, WebShell.Utilities.User.Id, view.Title, isPublic, view.Tag, view.Note))
            {
                result.Data = "1";
                result.Success = true;
            }
            else
            {
                result.Data = "0";
                result.Success = false;
            }

            return result;
        }
        IResult Delete_POST()
        {
            IResult result = new Result();
            dynamic view = new NoteView();
            presenter.SetViewModel(view);
            if (WebNoteBiz.DeleteNote(view.NoteId))
            {
                result.Data = "1";
                result.Success = true;
            }
            else
            {
                result.Data = "0";
                result.Success = false;
            }

            return result;
        }
        /// <summary>
        /// get user notes
        /// </summary>
        IResult MyNotes_Get()
        {
            IResult result = new Result();
            dynamic view = new MyNotes();
           // view.Notes = AppData.GetBaseUrl() + "note/MyNotes_Ajax/";
            view.Notes = WebNoteBiz.GetUserNotes(WebShell.Utilities.User.Id);
            HttpContext.Current.Session["activeMI"] = "my_notes";
            string AjaxUrlEdit = AppData.GetBaseUrl() + "note/edit";
            string AjaxUrlDelete = AppData.GetBaseUrl() + "note/delete";
            view.SetValue("AjaxUrlEdit", AjaxUrlEdit);
            view.SetValue("AjaxUrlDelete", AjaxUrlDelete);
            result= presenter.GetViewHTML("mynotes.htm", view);
            return result;
            
        }

        IResult MyNotes_Ajax_Get()
        {
            IResult result = new Result();
            result.Data = WebNoteBiz.GetUserNotes(WebShell.Utilities.User.Id);
            result.Success = true;
            return result;

        }
        
    }
}
