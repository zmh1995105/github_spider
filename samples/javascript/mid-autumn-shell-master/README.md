# mid autumn shell
/**
 * @author xiaofeng
 * @time 2015-09-27
 *
 * jquery.terminal
 * easy admin web shell
 *
 * 使用jquery.terminal插件构建的简单的后台管理用的简单webshell
 * 注意：
 * 只在vagrant ubuntu server 14 上测试通过
 * 只处理了当前目录问题
 * 未做shell命令注入过滤
 * 需要做可执行命令的白名单
 * 需要做登录权限认证
 * ......
 *
 * 2015-10-9
 * bugfix 对命令进行htmlEntityDecode，可以使用如下命令
 * curl -X POST -d '{"start_time":1444271999}' http://path
 * feature 添加eval
 * eval return 1 + 1;
 * eval echo 'hello';
 *
 * TODO:
 * 添加Relefction执行被禁止函数
 */
