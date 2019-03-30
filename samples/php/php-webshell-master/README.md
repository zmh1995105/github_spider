# webshell
1. 个人收集到的多个php免杀后门webshell，用于学习webshell免杀技术  
2. 这些webshell源程序，经过测试可以免杀[百度webshell扫描](https://scanner.baidu.com/#/pages/intro)、阿里云盾等
3. 不同webshell在项目根目录下以单独目录形式存放

## 列表 ##
1. **webshell8**  
[http://webshell8.com/](http://webshell8.com/)下载到的免杀webshell，有后门，谨慎上传到线上服务器  
/dist   -    webshell程序发布目录，去除后门的二次发布目录  
/src    -    源码  
/src/ext  -  被shell.php后门感染后自动在网站根目录生成的webshell样本


2. **strrev**  
网站空间上收集到的免杀webshell，功能较为简单，能上传下载文件、列出目录等  
shell.php  -  源程序  
shell_real.php  -  还原并加注释的真实代码  


2. **httpcopy**  
文件传输型webshell，不免杀，能被百度webshell扫描识别为网站后门，未详细分析


