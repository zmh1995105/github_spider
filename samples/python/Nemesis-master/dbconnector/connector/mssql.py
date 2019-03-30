import pymssql
try:
    from baseDB import BaseConnector
except:
    from .baseDB import BaseConnector
    
    
class MSsqlConnector(BaseConnector):
    
    default_port = "1433"
    
    def __init__(self, host, uname, passwd, port):
        if not port:
            port = self.default_port
        else:
            port = str(port)
        self.type = pymssql
        super().__init__(host, uname, passwd, port)

        
if __name__ == "__main__":
    a = MSsqlConnector("127.0.0.1", "sa", "test123", "1433")
    print(a)
    #a.sql_exec("SELECT * FROM dzpdata2017.dbo.BBS LIMIT 0, 1")