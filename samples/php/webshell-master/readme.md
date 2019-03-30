##PHP Web Shell 控制台
---

###特点
 - 功能模块化
 - 请求和执行代码分离
 - 通过替换不同的驱动可接驳不同木马
 
###目录
 - shells - 几个一句话木马
 - driver - 木马驱动
 - modules - 功能模块
 
###模块开发
 - 页面文件 `html.php` , `html_<id>.php`
 - 脚本文件 `script.php` , `script<id>.php`, 使用数组`$VAR`引入变量

###驱动开发
继承实现抽象类`ShellDriver`