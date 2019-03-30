using System;
using System.Collections.Generic;
using System.Text;
using System.Configuration;
using System.Collections;

namespace WebShell.Utilities.Configuration.Section
{
    public class SettingCollection : ConfigurationElementCollection
    {
        public SettingElement this[int index]
        {
            get
            {
                return base.BaseGet(index) as SettingElement;
            }

        }

        public SettingElement this[string key]
        {
            get
            {
                return base.BaseGet(key) as SettingElement;
            }
        }

        protected override ConfigurationElement CreateNewElement()
        {
            return new SettingElement();
        }

        protected override object GetElementKey(ConfigurationElement element)
        {
            return ((SettingElement)element).Key;
        }
    }
}

