# Nimbusec Website Security Monitor & Abuse Process Automation

This is a plesk extension compatible with versions 12.5 and above. 

## Install
To install the extension you can either use the official Plesk Extension Catalogue or you can package this repository as zip-file and upload it via the Plesk Admin Panel.
As an alternative you can also install it via command line on your plesk host (note: use the zip-file name here).

    $PLESK_INSTALL_DIR/bin/extension -i nimbusec-plesk.zip

Please note that downloading this Repository as zip-File or downloading the Release-zip-File will not result in a file structure that can be imported into Plesk since all files and directories are part of the sub-directory nimbusec-plesk.

The zip-file must have a structure similar to the following

    nimbuse-plesk.zip
     -htdocs/
     -plib/
     -var/
     -meta.xml

For installing the extension via zip file you can use the file [nimbusec-plesk.zip](https://github.com/cumulodev/nimbusec-plesk/releases/download/v1.0.3/nimbusec-plesk.zip) which is attached to the current release.

## Uninstall
To ninstall the extension you can either remove it via the Plesk Admin Panel  or use the commandline (note: use the plesk extension id here - nimbusec-hoster-integration
    
    $PLESK_INSTALL_DIR/bin/extension -u nimbusec-hoster-integration

## Features
This plesk extension allows you to:
* Manage credentials to access our API
* Enable/Disable domains on your plesk host to be scanned with nimbusec
* Manage the schedule of the automated scan tasks of Nimbusec on your plesk host
* Show results/issues in dashboard
* Manage results/issues via dashbaord

## Further Information
For further information please visit https://nimbusec.com or you can write us an e-mail to office@nimbusec.com
