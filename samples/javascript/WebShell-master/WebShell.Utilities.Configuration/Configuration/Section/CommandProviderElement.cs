using System;
using System.Collections.Generic;
using System.Text;
using System.Configuration;

namespace WebShell.Utilities.Configuration.Section
{
    public class CommandProviderElement:ConfigurationElement
    {
        [ConfigurationProperty("name")]
        public string Name
        {
            get { return (string)this["name"]; }
            set { this["name"] = value; }
        }

        [ConfigurationProperty("providerType",IsRequired=true)]
        public string ProviderType
        {
            get { return (string)this["providerType"]; }
            set { this["providerType"] = value; }
        }
       
    }
}
