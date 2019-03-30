class BaseConnector(object):
    
    iscreate = False
    
    def __init__(self, host, uname, passwd, port):
        self.db = self.type.connect(host, uname, passwd, port=port)
        print("[+]Connect OK")
        print(f"[+]INFO: Connect to {host}:{port} with {uname}")
        if not self.iscreate:
            self.cursor = self.db.cursor()
            self.iscreate = True
            
    def sql_exec(self, sql):
        try:
            self.cursor.execute(sql)
            results = self.cursor.fetchall()
            for rows in results:
                for cells in rows:
                    print(str(cells)+'\t', end='')
                print('')
            if sql[:6].upper() != "SELECT":
                self.db.commit()
            print("\n[+]Exec succeed")
        except:
            print("\n[!]Exec faild")
            self.db.rollback()
    
    def __repr__(self):
        return str(self.type)+" : "+str(self.default_port)