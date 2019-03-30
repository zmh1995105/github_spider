drugged-cat
===========

A PHP Webshell inspired on a crazy episode of my own cat.

Default login are

User: Rainbow

Pass: DruggedCatAuth

Features
=========== 

>> File Manager

- Uploader
- Embed backdoor on any file.
- Copy file or dir, move file or dir.
- Make file or directory, Delete file or directory.
- Change perms of any file or directory of the system, the user need perms to do that.
- Options to edit a existent file, download it or delete, for directories just exist delete option.
- Show perms (On dirs and files), and size (But just in files, maybe I do the same with the directories).

>> System information

- Detection of the OS and version.
- IP Address of server, show the state of safe_mode, cURL, GCC, etc.

>> SQL Navigator

- Compatibility for MySQL and PostgreSQL, maybe in the future I'll add MSSQL or Oracle.
- Capacity to navigate between tables and columns.
- Dump DB (.sql)
- Querys

>> Zapper

- Delete Logs (Linux, FreeBSD), Some dirs and files are missing for Windows, but works (I think, not tested).

>> Encrypt and Decrypt

- Base64, MD5 y SHA1.

>> Other stuffs

- ReverseDNS: Capacity to fetch domains on the same machine, not work if safe_mode are ON.
- Term to execute commands based on Unix style.
- Suicide, ¡Let suicide the shell!.
