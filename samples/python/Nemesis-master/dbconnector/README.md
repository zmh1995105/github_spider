## 命令行主流SQL型数据库连接工具

起因是在做渗透测试时发现泄露了sa账户密码，但在网上没有找到命令行工具

---

支持：

- [x] MySQL
- [x] SQL Server
- [ ] Oracle

关于Oracle，因为本地没有Oracle环境，暂时没有完成代码

---

```
Usage:

Send args like this:
         python main.py mysql://root:test123@127.0.0.1
         python main.py mysql://root:test123@127.0.0.1:3306
If there are specia symbols in passwd, wrap it with ``:
         python main.py mysql://root:`abc@#123`@127.0.0.1:3306
Then U can exec origin sql query
Enter 'exit' to exit
```

如密码含有特殊字符则需使用飘号包裹，可执行原生SQL语句如：

+ SELECT * FROM xx.xx;
+ CREATE TABLE xx.xx(id int, name varchar(48));
+ DROP TABLE xx.xx;
