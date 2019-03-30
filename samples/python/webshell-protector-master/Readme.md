# Webhshell Protector

A small POC of a technique to defend a webserver from malicious code execution originating from planted webshells

## How it works:
1. Using winappdbg we look for a running IIS process (w3wp.exe)
2. A breakpoint is set on `CreateProcessW`
3. The `lpCommandLine` parameter is examined, and if it looks malicious, we can null the pointer and execution will be prevented!

* Currently the way I'm checking if the process to be created is really naive, but it can be extended easily to include additional checks, for example a whitelist of file hashes permitted to execute from `w3wp.exe`, a check against VT, etc...

## Demo:
![alt text](https://github.com/mkorman90/webshell-protector/raw/master/pics/poc.gif)