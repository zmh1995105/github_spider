using System;
using System.Collections.Generic;
using System.Text;
using System.Configuration;
using System.Collections;

namespace WebShell.Utilities.Configuration.Section
{
    public class SettingElement : ConfigurationElement
    {
        [ConfigurationProperty("key", IsRequired = true)]
        public string Key
        {
            get { return this["key"] as string; }
        }

        [ConfigurationProperty("value", IsRequired = true)]
        public string Value
        {
            get { return this["value"] as string; }
        }
    }
}

