# DotNET-Core-Playground
Testing webshells and the like with MVC and Dot NET Core

## Razor Webshell
### Using the webshell
The webshell itself is `MVCShell/Views/Home/Shell.cshtml` (for Linux and Mac) and `MVCShell/Views/Home/WinShell.cshtml` (for Windows). You can play with it as well by selecting `NixSh3ll` or `WinSh3ll` on the top menu of the home page. You only need those files for scenarios where you may need a .NET Core or MVC webshell. This will only work with web solutions that run views that are rendered on the server using Razor syntax (files with a `.cshtml` extention).    

<img src="https://github.com/auseche-r7/DotNET-Core-Playground/blob/master/MVCShell/wwwroot/images/demo.gif" />

### LFI Sample
The home page allows you to test LFI with the webshell. I will be adding demos for RFI as well soon.

To get the LFI working the url should look something like this

`http://localhost:5000/Home?tpl=~/Views/Home/Shell.cshtml&cmd=ls`

The above simulates a web page that pulls a partial view from `~/Views/Home/Shell.cshtml`. You can simply enter `http://localhost:5000/Home?tpl=~/Views/Home/Shell.cshtml` and ommit the `cmd` argument, as it will be added for you when entering commands in the shell.

### RFI Sample 
In progress

### Caveats
* There needs to be an controller route to the shell you are injecting, so this would be useful in an scenario where you can replace a local file that gets rendered as a partial razor view. I am currently testing for RFI to find ways to elimite this caveat. 
