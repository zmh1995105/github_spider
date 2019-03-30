using System;
using System.Collections.Generic;
using System.Text;
using WebShell.ClassLibrary;
using System.Web;
using WebShell.Utilities;
using WebNote.ViewModels;
using WebNote.DB.Business;
using System.Web.Script.Serialization;
using System.Reflection;

namespace WebNote.Users
{
    [WebShell.ClassLibrary.LoginRequired()]
   public class UsersCommand:ICommand
    {
        static IPresenter presenter = ObjectBuilder.CreateFrom(WebShellConfig.GetCommandType("presenter")).Data as IPresenter;

        #region ICommand Members
  
        public IResult Execute(string command)
        {
            IResult result = new Result();
            string strCommandName = GetCommand(command);
            string strMethodName = strCommandName.ToLower() + "_" + HttpContext.Current.Request.HttpMethod.ToLower();
            MethodInfo mi = ObjectBuilder.GetMethodInfo(this, strMethodName);
            result = mi.Invoke(this, null) as IResult;

            return result;
        }

        public string GetCommand(string command)
        {
            string strCommandName = command.ToLower();
            if (strCommandName.StartsWith("/"))
            {
                strCommandName = strCommandName.Remove(0, 1); 
            }
            if (strCommandName!= string.Empty)strCommandName = strCommandName.Split('/')[0];
            else strCommandName = "default";

            return strCommandName;
        }
        #endregion


        #region Command URL Methods
        public IResult Default_GET()
        {
            IResult result = new Result();
            result = presenter.GetViewHTML("home.htm");

            return result;
        }

        public IResult Default_POST()
        {
            IResult result = new Result();
            dynamic view = new NoteView();
            presenter.SetViewModel(view, HttpContext.Current.Request);

            return result;
        }
        IResult Register_GET()
        {
            IResult result = new Result();
            HttpRequest httpRequest = HttpContext.Current.Request;
            dynamic view = new UserView();
            result = presenter.GetViewHTML("adduser.htm");
          
            return result;
        }

         IResult Register_POST()
         {
             IResult result = new Result();
             HttpRequest httpRequest = HttpContext.Current.Request;
             dynamic view = new UserView();
             presenter.SetViewModel(view, httpRequest);
             long userId = WebNoteBiz.AddUser(view.Email, view.Password);
             WebShell.Utilities.User.Id = userId;
             WebShell.Utilities.User.Email = view.Email;
             HttpContext.Current.Session["activeMI"] = "public_notes";
             HttpContext.Current.Response.Redirect(AppData.GetBaseUrl());
             return result;
         }

         //IResult Login_GET()
         //{
         //    IResult result = new Result();
         //    HttpRequest httpRequest = HttpContext.Current.Request;
         //    dynamic view = new UserView();
         //    result = presenter.GetViewHTML("login.htm");

         //    return result;
         //}
        #endregion
        
    }
}
