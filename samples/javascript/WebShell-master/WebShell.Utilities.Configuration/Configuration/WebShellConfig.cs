using System;
using System.Collections.Generic;
using System.Text;
using System.Configuration;
using System.Reflection;
using WebShell.Utilities.Configuration.Section;
using WebShell.ClassLibrary;

namespace WebShell.Utilities
{
    public static class WebShellConfig
    {
        static WebShellSection shellSectin = (WebShellSection)ConfigurationManager.GetSection("webShell");

        public static Type GetCommandType(string name)
        {
            Type commandProviderType = Type.GetType(shellSectin.Commands[name].ProviderType);
            if (commandProviderType == null)
                throw new Exception("Command provider section is not configured properly");
            return commandProviderType;
        }

        //public static Type GetPresenterType()
        //{
        //    Type presnterType = Type.GetType(shellSectin.Presenter.ProviderType, true);
        //    if (presnterType == null)
        //        throw new Exception("Presenter provider section is not configured properly");
        //    return presnterType;
        //}

        ////TODO: for presenter, logger and security add code to use default framework DLLs

        //public static Type GetLoggerType()
        //{
        //    Type loogerType = Type.GetType(shellSectin.Logger.ProviderType, true);
        //    if (loogerType == null)
        //        throw new Exception("Logger provider section is not configured properly");
        //    return loogerType;
        //}

        //public static Type GetSecurityType()
        //{
        //    Type loogerType = Type.GetType(shellSectin.Security.ProviderType, true);
        //    if (loogerType == null)
        //        throw new Exception("Security provider section is not configured properly");
        //    return loogerType;
        //}


        public static string GetSetting(string name)
        {
            return shellSectin.Settings[name].Value.ToString();
        }

        //public static string Root
        //{
        //    get 
        //    {
        //        string root = string.Empty;
        //        try
        //        {
        //            root = shellSectin.Settings["root"].Value.ToString();
        //            return root;
        //        }
        //        catch (Exception ex)
        //        {
        //            //TODO: add apropriate message here concerned with ex => Low priorty
        //            throw ex;
        //        }
        //    }
        //}

        
    }
}
