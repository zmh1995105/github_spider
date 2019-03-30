# typecho_auto_getshell
typecho自动化写webshell

收集模块还有点小问题，钟馗之眼有反爬机制，暂时还没捣鼓出来，所以DOMAIN.txt文件用的采集器采集的。
然后自动化识别国内网站功能暂时还没实现，目前需要跑完confirm_ip.py之后手动删除中国站点。

使用流程：   
1.运行confirm_ip.py在domain.txt中导入域名，一键查询站点归属地，并写入target_url.txt    
2.手动删除target_url.txt中的中国站点（后续更新自动化识别）    
3.运行typecho_exp_script.py，从target_url获取域名，批量上webshell  
