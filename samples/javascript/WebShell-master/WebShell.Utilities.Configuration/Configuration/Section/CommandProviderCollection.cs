using System;
using System.Collections.Generic;
using System.Text;
using System.Configuration;
using System.Collections;

namespace WebShell.Utilities.Configuration.Section
{
    public class CommandProviderCollection : ConfigurationElementCollection
    {

        public CommandProviderElement this[int index]
        {
            get
            {
                return base.BaseGet(index) as CommandProviderElement;
            }
            set
            {
                if (base.BaseGet(index) != null)
                {
                    base.BaseRemoveAt(index);
                }
                this.BaseAdd(index, value);
            }
        }

        public CommandProviderElement this[string name]
        {
            get
            {
                return base.BaseGet(name) as CommandProviderElement;
            }
        }
        protected override ConfigurationElement CreateNewElement()
        {
            return new CommandProviderElement();
        }

        protected override object GetElementKey(ConfigurationElement element)
        {
            return ((CommandProviderElement)element).Name;
        }
    }
}
