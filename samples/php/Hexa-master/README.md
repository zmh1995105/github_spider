<img src="icon.png" align="right" />

# Hexa Webshell
> A webshell written in php with handy features

## Usage
Basic GET syntax for hexa:
```

    HexaShell.php?session_pwd=PASSWORD&shell=COMMAND[ARG1,ARG2...]
    
    PASSWORD                        Session password.
    COMMAND                         Command to execute to.

```

Available commands:
-------------------
```

    Shell commands:
    ----------------
    help                            Show this help.
    remove                          Remove shell from machine.

    File operations:
    ----------------
    get[FILE]                       Download file from this machine.
    urlget[URL,NEW]                 Download file from url to this machine.
    hide[FILE/DIR]                  Hide directory or file.
    delete[FILE/DIR]                Delete file or folder.
    create[FILE]                    Create blank file.
    copy[OLD,NEW]                   Copy file or folder.
    rename[OLD,NEW]                 Rename a file or folder.
    view[FILE]                      View file content.
    replace[FILE,CODE/URL]          Replace file content with custom code.
    encrypt[OBJ,SECRET,IV]          Try to encrypt file or folder with AES.
    decrypt[OBJ,SECRET,IV]          Try to encrypt file or folder with AES.
    finfo[FILE]                     Show file information.
    find[PATTERN,OBJ]               Find pattern in strings, files or directory's.

    System and db operations:
    -------------------------
    tasklist                        Show list of running processes.
    taskkill[TASK]                  Try to kill task.
    sysinfo                         Show advanced system information.
    geoinfo                         Show geoip information.
    phpinfo                         Show php information.
    query[QUERY,USER,PASS,DB]       Execute mysql query.
    eval[CODE/RAW_URL]              Evaluate a string as PHP code or run from raw url.
    
    Network:
    --------
    pscan[HOST,RANGE]               Perform port scan. Example range: 0-80000

```

## Maintainers
[@Nico Duitsmann (3v1l_un1c0rn)](https://github.com/nico-duitsmann)

## License
[GNU GPL v3](LICENSE) ©Nico Duitsmann