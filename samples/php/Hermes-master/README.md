# Magician
A WebShell Scanner, one part of Tarot Plan.

主要用于公司内网检测webshell,
功能包括：
- 本机扫描
- 目录指定
- 远程扫描，指定目标ip或网段
- 扫描结果收集
- 报告自动生成

## Idea Collection

[Webshell代码检测背后的数学应用](http://www.freebuf.com/articles/4240.html)

## Plan

第一阶段：
完善webshell扫描脚本，增加对多线程的支持，提高扫描效率

第二阶段：
添加可视化界面

## Technology

- Python2.7
- Flask

## Idea

目前WebShell扫描器判断目标的依据
- 文件后缀，常见的如jsp, php, asp等
- 关键字，读取文件内容看是否包含敏感词
- 文件大小，目前市面上常见的webshell会且必须尽量减少代码量，压缩自身体积，size < 500k
