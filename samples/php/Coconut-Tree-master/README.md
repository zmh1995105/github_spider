# Coconut Tree Webshell Manage（椰子树webshell管理器）


### 介绍

Coconut Tree是一款webshell管理工具。不同于市面上常见的webshell管理器，如菜刀之类的是，Coconut Tree是一款实时密码webshell管理器。也就是说Coconut Tree只能连接Coconut Tree专用的webshell，其webshell的密码是实时更新，每一次链接的密码都不相同。采用一次一密的方法，保证了webshell的专用性。


webshell下有一个PHP后门木马，`Coconut_tree.php`是混淆过的PHP后门木马。

`Coconut_tree.php`内置多种代码执行方法。包括assert，eval，create_function和文件包含。兼容PHP5和PHP7，只需将其上传即可。

webshell下的`webshell.php`是`Coconut_tree.php`的源码


### 使用方法

git下载Coconut Tree

pip install -r requirements.txt   //安装第三方扩展包

运行Coconut_tree.py，建议使用python3运行。

`python3 Coconut_tree.py webshell`

成功运行之后进入phpshell命令行，在phpshell中可执行任意PHP代码。
