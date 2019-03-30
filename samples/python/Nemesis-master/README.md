# Nemesis
命令行网站管理工具

名字取义自北欧神话的复仇女神`Nemesis`

***

运行于Python 3.x

支持：

Webshell：

- [x] PHP + Linux

- [x] PHP + Windows

- [x] Aspx + Windows

- [ ] Asp + Windows

- [ ] Jsp + Windows

- [ ] Jsp + Linux

数据库连接：

- [x] MySql

- [x] MSSql

- [ ] Oracle

***

**How to use:**

```
> git clone https://github.com/EddieIvan01/Nemesis.git
> cd Nemesis
> python3 nemesis.py http://127.0.0.1/shell.php pass

         _   _                                   _
        | \ | |   ___   _ __ ___     ___   ___  (_)  ___
        |  \| |  / _ \ | '_ ` _ \   / _ \ / __| | | / __|
        | |\  | |  __/ | | | | | | |  __/ \__ \ | | \__ \
        |_| \_|  \___| |_| |_| |_|  \___| |___/ |_| |___/

             /* Webshell Manager */

[+]Initialize...
[+]Set URL => http://127.0.0.1/shell.php
[+]Set Language => php
[+]Set Encode => utf-8
/var/www> ls
_index.php
ins.py
result.xls
shell.php
test

/var/www> exit
```

***

Usage:

```
usage:
  Manager mode(for manage shells):  ./nemesis.py [-h] [-p PROXY]
  Normal mode(for only one shell):  ./nemesis.py URL PASSWD [-h] [-l LANG] [-p PROXY]
  DB mode(for connect to database): ./nemesis.py DBURI(e.g. mysql://root:test123@127.0.0.1:3306) [-h]

optional arguments:
  -h, --help            show this help message and exit
  -l LANG, --lang LANG  if webshell's language is diffrent to file suffix
                        name, use it
  -p PROXY, --proxy PROXY
                        requests' proxy, e.g: socks5://127.0.0.1:1080
```



三种模式：

+ Manager模式：

  ```
  # 直接启动
  # 读取本地config.json中的Webshell list
  
  > python3 nemesis.py
           _   _                                   _
          | \ | |   ___   _ __ ___     ___   ___  (_)  ___
          |  \| |  / _ \ | '_ ` _ \   / _ \ / __| | | / __|
          | |\  | |  __/ | | | | | | |  __/ \__ \ | | \__ \
          |_| \_|  \___| |_| |_| |_|  \___| |___/ |_| |___/
  
               /* Webshell Manager */
  
  [+]Initialize...
  
  [*]Manager mode command:
       enter [index]                       --choose a shell to use
       set [index]:[encode | pwd] xxx      --change shells' encode or passwd
       flag                                --find flag in ctf
       exit
  
  [*]Webshell list
  [0] URL => http://127.0.0.1/shell.php   PWD =>pass   OS => win   ENCODE => gbk
  [1] URL => http://192.168.43.100/shell.php   PWD =>pass   OS => linux   ENCODE => utf-8
  [2] URL => http://192.168.43.105/shell.php   PWD =>pass   OS => win   ENCODE => gbk
  [3] URL => http://192.168.43.109/shell.php   PWD =>pass   OS => win   ENCODE => gbk
  
  @Nemesis>
  ```

  Manager Mode Usage

  + enter [index]   进入一个Webshell交互式终端
  + set [index]:[encode | pwd] xxx   修改Webshell的编码或passwd
  + flag   自动寻找Flag（CTF专用）
  + exit   退出

+ Shell模式

  ```
  # 进入单一shell
  > python3 nemesis.py http://127.0.0.1/shell.php pass
  ```

+ DB模式

  ```
  # 连接MySql/MSSql数据库
  > python3 nemesis.py mysql://root:root@127.0.0.1
  ```

***

**Tips：**

+ 默认Webshell语言为URL后缀，假如连接的是图片马 or 混淆后缀：使用`-l`或`--lang`

  ```
  > python3 nemesis.py http://127.0.0.1/shell.php.jpg pass -l php
  ```

+ 连接Webshell时使用代理：`-p`或`--proxy`

  ```
  # SSR
  > python3 nemesis.py http://127.0.0.1/shell.php pass -p socks5://127.0.0.1:1080
  
  # BurpSuite
  > python3 nemesis.py http://127.0.0.1/shell.php pass -p http://127.0.0.1:8080
  
  # Tor
  > python3 nemesis.py -p socks4://127.0.0.1:9050
  ```

+ CTF中一键寻找Flag，有几次拿到shell了确花了半天找flag究竟在根目录还是Web根目录还是在哪哪哪儿，故写了此功能，只能在Manager Mode运行，寻找所有名字带flag的文件，读取后正则匹配`/(\w+\{[-\w]+\})/`：

  ```
  > python3 nemesis.py
           _   _                                   _
          | \ | |   ___   _ __ ___     ___   ___  (_)  ___
          |  \| |  / _ \ | '_ ` _ \   / _ \ / __| | | / __|
          | |\  | |  __/ | | | | | | |  __/ \__ \ | | \__ \
          |_| \_|  \___| |_| |_| |_|  \___| |___/ |_| |___/
  
               /* Webshell Manager */
  
  [+]Initialize...
  
  [*]Manager mode command:
       enter [index]                       --choose a shell to use
       set [index]:[encode | pwd] xxx      --change shells' encode or passwd
       flag                                --find flag in ctf
       exit
  
  [*]Webshell list
  [0] URL => http://127.0.0.1/shell.php   PWD =>pass   OS => win   ENCODE => gbk
  
  @Nemesis> flag
  [+]Enter index: 0
  [+]Enter dir: f
  
  [+]Flag files:
  f:\flag
  f:\HackTo0ls\审计\GitHack\web.jarvisoj.com_32798\templates\flag.php
  f:\tim_recv_file\MobileFile\flag.py
  f:\tim_recv_file\MobileFile\flag.txt
  
  [+]Flag found in f:\flag: abc{asdasd798yh9da7yas9dy7}
  
  [+]No flag found in: f:\HackTo0ls\审计\GitHack\web.jarvisoj.com_32798\templates\flag.php
  
  [+]No flag found in: f:\tim_recv_file\MobileFile\flag.py
  
  [+]No flag found in: f:\tim_recv_file\MobileFile\flag.txt
  
  
  [*]Webshell list
  [0] URL => http://127.0.0.1/shell.php   PWD =>ck   OS => win   ENCODE => gbk
  
  @Nemesis>
  ```

+ 连接数据库时假如密码含有特殊字符如`@`，会对parse造成干扰，需使用飘号包裹：

  ```
  mysql://root:`abc@#123`@127.0.0.1:3306
  ```
