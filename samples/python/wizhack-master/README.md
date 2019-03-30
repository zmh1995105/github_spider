Wizhack
=======
Get shellcodes and webshells quickly.

Installation :
--------------

`$ git clone https://github.com/cryptobioz/wizhack`

`$ cd wizhack`

`$ make install`

Usage :
-------

Get a reverse-shell-tcp shellcode for x86 Linux :

`$ wizhack shellcode x86/linux reverse-shell-tcp`

Copy a shellcode to clipboard :

`$ wizhack shellcode x86/linux exec-basic-sh -c`

Export a PHP webshell to a file :

`$ wizhack webshell php c99 -o /tmp/webshell.php`
 
