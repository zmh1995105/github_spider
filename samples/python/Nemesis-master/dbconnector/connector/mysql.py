import pymysql
try:
    from .baseDB import BaseConnector
except:
    from baseDB import BaseConnector

    
class MysqlConnector(BaseConnector):
    
    default_port = 3306
    
    def __init__(self, host, uname, passwd, port=None):
        if not port:
            port = self.default_port
        self.type = pymysql
        super().__init__(host, uname, passwd, port)

        
if __name__ == "__main__":
    a = MysqlConnector(host="127.0.0.1", uname="root", passwd="root", port=3306)
    print(a)
    a.sql_exec("SELECT * FROM security.users")
    a.sql_exec("CREATE TABLE security.test(id int, name varchar(255))")
    a.sql_exec("DROP TABLE security.test")