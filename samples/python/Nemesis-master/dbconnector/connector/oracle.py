import cx_Oracle
    
class OracleConnector():
    
    def __init__(self, host, uname, passwd, db, port="1521"):
        dsn = cx_Oracle.makedsn(host, port, db)
        self.conn = cx_Oracle.connect("root", "test123", dsn)
        '''
        do some sql process
        '''
        pass
    
if __name__ == "__main__":
    pass