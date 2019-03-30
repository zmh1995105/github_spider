using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using WebShell.ClassLibrary;
using System.Reflection;
using System.Web;
using WebNote.ViewModels;
using WebShell.Utilities;
//using WebShell.ut

namespace WebShell.Providers.Security
{
    public class Security:ISecurity,ICommand
    {
        static IPresenter presenter = ObjectBuilder.CreateFrom(WebShellConfig.GetCommandType("presenter")).Data as IPresenter;

        public bool IsValidUser()
        {
            if (WebShell.Utilities.User.Id != -1)
                return true;
            else return false;
        }

        public bool IsValidRole()
        {
            throw new NotImplementedException();
        }

        public IResult Login(string ReturnCommandName)
        {
            throw new NotImplementedException();
        }

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
            if (strCommandName != string.Empty) strCommandName = strCommandName.Split('/')[0];
            else strCommandName = "default";

            return strCommandName;
        }
        #endregion

        IResult Login_GET()
        {
            IResult result;
            if (HttpContext.Current.Request.QueryString["e"] != null)
            {
                dynamic view = new LoginView();
                view.InvalidPwd = "Invalid Login";
                view.Email = string.Empty;
                result = presenter.GetViewHTML("login.htm", view);
            }
            else 
            {
                result = presenter.GetViewHTML("login.htm");
            }
            return result;
        }
        IResult Logout_GET()
        {
            IResult result = new Result();

            HttpContext.Current.Session.Abandon();
            HttpContext.Current.Session.Clear();
            HttpContext.Current.Response.Redirect(AppData.GetBaseUrl());
            return result;
        }
        IResult Login_POST()
        {
            IResult result = new Result();
            HttpRequest httpRequest = HttpContext.Current.Request;
            string redirectURL = string.Empty;
            if (httpRequest.QueryString["r"] != null)
                redirectURL = httpRequest.QueryString["r"];

            dynamic view = new LoginView();
            presenter.SetViewModel(view);
            long userId;
            if (WebNote.DB.Business.WebNoteBiz.IsValidPassword(view.Email, view.Password,out userId))
            {
                User.Id = userId;
                User.Email = view.Email;
                if (redirectURL != string.Empty)
                {
                    HttpContext.Current.Session["activeMI"] = "public_notes";
                    result.Success = true;
                    HttpContext.Current.Response.Redirect(AppData.GetBaseUrl() + redirectURL);
                }
                else
                {               
                    HttpContext.Current.Session["activeMI"] = "public_notes";
                    result.Success = true;
                    HttpContext.Current.Response.Redirect(AppData.GetBaseUrl() + redirectURL);
                }
            }
            else //invalid login
            {
                result.Success = false;
                HttpContext.Current.Response.Redirect(HttpContext.Current.Request.Url.AbsolutePath + "/security/login/?r=" + redirectURL + "&e=il", false);
            }

            return result;
            
        }
    }
}
