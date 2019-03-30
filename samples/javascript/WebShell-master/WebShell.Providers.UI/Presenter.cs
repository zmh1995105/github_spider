using System;
using System.Collections.Generic;
using System.Text;
using System.Web;
using System.Reflection;
using System.Text.RegularExpressions;
using System.IO;
using WebShell.ClassLibrary;
using WebShell.Providers.UI.Properties;
using WebShell.Utilities;

namespace WebShell.Providers.UI
{
    public class Presenter:IPresenter
    {
        public IResult GetViewHTML(string resourceName, dynamic viewType=null)
        {
            Result result= new Result();
            try
            {
                if (resourceName.StartsWith("/")) resourceName = resourceName.Remove(0, 1);
                string rPath = HttpContext.Current.Request.PhysicalApplicationPath + "html\\" + resourceName;
                string strResourceText = File.ReadAllText(rPath);
                string strFinalText = ParsResourceText(strResourceText, viewType);
                result.Data = strFinalText;
                result.Success = true;
            }
            catch (Exception ex)
            {
                result.Success = false;
                throw ex;
                //TODO: log the error
            }
                return result; 
            
        }

        private string ParsResourceText(string strResourceText, dynamic viewType = null)
        {
            string strBasicText = string.Empty;
            //check for {% extends "base.htm" %} Tag and then substitute block cont
            Match matchExtends=Regex.Match(strResourceText, Settings.Default.Reg_Extend);
            if (matchExtends.Success)
            {
                Match matchFilePath = Regex.Match(matchExtends.Value, Settings.Default.Reg_FilePath);
                string strBasePath = string.Empty;
                if (matchFilePath.Success) strBasePath = matchFilePath.Groups[0].Value;
                strBasePath = strBasePath.Replace("\"", "");// remove "" from file path
                strBasePath = HttpContext.Current.Request.PhysicalApplicationPath + "html\\" + strBasePath;
                string strBaseContent = File.ReadAllText(strBasePath);
                //substitute blocks content, {% block someblock %} some content {% endblock %}
                foreach (Match matchBaseBlock in Regex.Matches(strBaseContent, Settings.Default.Reg_BlockStart))
                {
                    string strBlockName = Regex.Replace(matchBaseBlock.Value, Settings.Default.Reg_BlockName, "");
                    string strPattern = Settings.Default.Reg_BlockStartSearch.Replace("\\w*", strBlockName)
                        + Settings.Default.Reg_BlockContent
                        + Settings.Default.Reg_BlockEndSearch;
                    Match matchResourcBlock = Regex.Match(strResourceText, strPattern);
                    if (matchResourcBlock.Success)
                    {
                        strBaseContent = strBaseContent.Replace(matchBaseBlock.Value, matchResourcBlock.Value);
                    }

                }
                //set basic text for next manpulation
                strBasicText = Regex.Replace(strBaseContent, Settings.Default.Reg_BlockEnd, "");
            }
            else
            {
                strBasicText = strResourceText;
            }

            //substitute {% include "somefile.ext" %}
            foreach (Match matchInclude in Regex.Matches(strBasicText, Settings.Default.Reg_Include))
            {
                string strFilePath = Regex.Match(matchInclude.Value, Settings.Default.Reg_FilePath).Value.Replace("\"", "").Replace("\'", "");
                strFilePath = HttpContext.Current.Request.PhysicalApplicationPath + strFilePath;
                string strIncludeText = File.ReadAllText(strFilePath);
                //replce tag with actualy content
                strBasicText = strBasicText.Replace(matchInclude.Value, strIncludeText);
            }

            //sustitute varaibles {{variable}}
            string strFinalText = strBasicText;

            foreach (Match matchVariable in Regex.Matches(strFinalText, Settings.Default.Reg_VarPattern))
            {
                string strPropName = Regex.Replace(matchVariable.Value, Settings.Default.Reg_VarName, "").Trim();
                if (viewType != null)
                {
                    PropertyInfo proInfo = viewType.GetType().GetProperty(strPropName, BindingFlags.IgnoreCase | BindingFlags.Public| BindingFlags.Instance);
                    if (proInfo != null)
                    {
                        object oVal = proInfo.GetValue(viewType, null);
                        if (oVal != null)
                            strFinalText = strFinalText.Replace(matchVariable.Value, oVal.ToString());
                    }
                    else if (HttpContext.Current.Session[strPropName] != null)
                    {
                        strFinalText = strFinalText.Replace(matchVariable.Value, HttpContext.Current.Session[strPropName].ToString());
                    }
                    else if (viewType is IView)
                    {
                        object oVal = (viewType as IView).GetValue(strPropName);
                        if (oVal != null)
                            strFinalText = strFinalText.Replace(matchVariable.Value, oVal.ToString());
                        else strFinalText = strFinalText.Replace(matchVariable.Value, "");
                    }
                    else
                    {
                        strFinalText = strFinalText.Replace(matchVariable.Value, "");
                    }
                }
                else//search for session keys
                {
                    if (HttpContext.Current.Session[strPropName] != null)
                    {
                        strFinalText = strFinalText.Replace(matchVariable.Value, HttpContext.Current.Session[strPropName].ToString());
                    }
                    else
                    {
                        strFinalText = strFinalText.Replace(matchVariable.Value, "");
                    }
                }
            }
            

            //substitute src and href
            string url = HttpContext.Current.Request.Url.AbsoluteUri.Replace(HttpContext.Current.Request.Url.PathAndQuery, "");
            url += HttpContext.Current.Request.ApplicationPath + "/html/";
            foreach (Match matchLink in Regex.Matches(strFinalText, Settings.Default.Reg_HTML_src_href))
            {
                string fileLink = Regex.Replace(matchLink.Value, Settings.Default.Reg_HTML_src_href_Replace, "");
                string thisUrl = url + fileLink;
                if (matchLink.Value.ToLower().StartsWith(" src"))
                {
                    strFinalText = strFinalText.Replace(matchLink.Value, " src=\"" + thisUrl + "\" ");
                }
                else if (matchLink.Value.ToLower().StartsWith(" href"))
                {
                    //update files links
                    if (System.IO.Path.GetExtension(thisUrl) != string.Empty )
                    strFinalText = strFinalText.Replace(matchLink.Value, " href=\"" + thisUrl + "\" ");
                    else //update WebShell Commands links
                        strFinalText = strFinalText.Replace(matchLink.Value, " href=\"" + thisUrl.Replace("/html","") + "\" ");
                }
            }
           
            return strFinalText;
        }
        
        public void SetViewModel(dynamic viewType, HttpRequest httpRequest)
        {
            if (httpRequest == null) httpRequest = HttpContext.Current.Request;
            
            foreach (PropertyInfo property in viewType.GetType().GetProperties())
            {
                if (property.CanWrite)
                {
                    //TODO: handle if request method "GET" to use url instead of form => medium
                    string[] values = httpRequest.Form.GetValues(property.Name);
                    if (values != null && values.Length > 0)
                    {
                        //TODO: support other data types => medium
                        object oValue;
                        if (property.PropertyType == typeof(Int64))
                        {
                            Int64 l;
                            Int64.TryParse(values[0], out l);
                            oValue = l;
                        }
                        else oValue = values[0];
                        property.SetValue(viewType, oValue, null);
                    }
                    else
                    {
                        //TODO: support other data types => medium
                        object oValue;
                        if (property.PropertyType == typeof(Int64))
                        {
                            oValue = -1;
                        }
                        else oValue = string.Empty;
                        property.SetValue(viewType, oValue, null);
                    }
                }
            }
           
        }

        public IResult Localize(string resourceName)
        {
            throw new Exception("Method not implemented");
        }
    }
}
