using System;
using System.Collections.Generic;
using System.Text;
using System.Configuration;

namespace WebShell.Utilities.Configuration.Section
{
    public class WebShellSection:ConfigurationSection
    {
        [ConfigurationProperty("commands", IsRequired=true)]
        public CommandProviderCollection Commands
        {
            get { return this["commands"] as CommandProviderCollection; }
           
        }

        [ConfigurationProperty("presenter", IsRequired = true)]
        public PresenterElement Presenter
        {
            get { return this["presenter"] as PresenterElement; }

        }

        [ConfigurationProperty("logger", IsRequired = true)]
        public LoggerElement Logger
        {
            get { return this["logger"] as LoggerElement; }

        }

        [ConfigurationProperty("security", IsRequired = true)]
        public SecurityElement Security
        {
            get { return this["security"] as SecurityElement; }

        }

        [ConfigurationProperty("settings", IsRequired = true)]
        public SettingCollection Settings
        {
            get { return this["settings"] as SettingCollection; }

        }
   
    }
}
