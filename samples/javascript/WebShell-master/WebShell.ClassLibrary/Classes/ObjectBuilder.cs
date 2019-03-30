using System;
using System.Collections.Generic;
using System.Text;
using System.Reflection;

namespace WebShell.ClassLibrary
{
    /// <summary>
    /// type creator 
    /// </summary>
   public class ObjectBuilder
    {
       static Dictionary<string, string> MethodsDic = new Dictionary<string, string>();

       public static IResult CreateFrom(Type type)
       {
           Result result = new Result();
           object oValue=Activator.CreateInstance(type);
           if (oValue == null)
           {
               result.Success = false;
               result.Data = "Object type is missed!";
           }
           else
           {
               result.Success = true;
               result.Data = oValue;
           }

           return result;
       }
       public static MethodInfo GetMethodInfo(object methodObject, string strMethodName)
       {
           string strKey = methodObject.ToString() + "." + strMethodName;
           if (MethodsDic.ContainsKey(strKey))
           {
               strMethodName = MethodsDic[ strKey];
           }
           else
           {
               foreach (MethodInfo mInfo in methodObject.GetType().GetMethods(BindingFlags.NonPublic | BindingFlags.Public | BindingFlags.Instance))
               {
                   if (mInfo.Name.ToLower() == strMethodName)
                   {
                       MethodsDic.Add(strKey, mInfo.Name);
                       strMethodName = mInfo.Name;
                       break;
                   }
               }
           }
           MethodInfo mi = methodObject.GetType().GetMethod(strMethodName, BindingFlags.NonPublic | BindingFlags.Public | BindingFlags.Instance);

           return mi;
       }
    }
}
