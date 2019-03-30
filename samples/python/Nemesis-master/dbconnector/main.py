from .connector import MysqlConnector, MSsqlConnector
import sys
import re


def usage():
    ar = sys.argv[1]
    if ar == '-h' or ar == '--help':
        print("Usage: \n\n"\
              "Send args like this: \n"\
              "         python main.py mysql://root:test123@127.0.0.1\n"\
              "         python main.py mysql://root:test123@127.0.0.1:3306\n"\
              "If there are specia symbols in passwd, wrap it with ``: \n"
              "         python main.py mysql://root:`abc@#123`@127.0.0.1:3306\n"\
              "Then U can exec origin sql query\n"\
              "Enter 'exit' to exit\n"
        )
        sys.exit(0)
        
        
def parse_args(ar):
    
    # mysql://root:test123@127.0.0.1
    # mysql://root:test123@127.0.0.1:3306
    # mysql://root:`abc@#123`@127.0.0.1:3306
    
    if not re.match(r'^.+://\w*:(\w*|`.+`)@(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}|\w+)(:\d{1,4})*[/\w*]*$', ar):
        print("[!]Args error")
        sys.exit(-1)
    dbtype = ar.split(r"://")[0]
    temp = ar.split(r"://")[1]
    uname = temp.split(":")[0]
    temp = ':'.join(temp.split(":")[1:])
    if temp[0] == '`':
        passwd = re.findall(r'`(.*)`', temp)[0]
        temp = temp.split('`')[-1]
    else:
        passwd = temp.split("@")[0]
    temp = temp.split("@")[1]
    host = temp.split(":")[0]
    port = int(temp.split(":")[1]) if len(temp.split(":"))!=1 else None
    return dbtype, uname, passwd, host, port

    
def shell_loop(db_obj):
        while True:
            sql = yield
            print()
            if sql.lower() == "exit":
                db_obj.db.close()
                sys.exit(0)
            try:
                db_obj.sql_exec(sql)
            except InterruptedError:
                db_obj.db.close()
            except:
                pass
        
        
def handler_db(uri):
    dbtype, uname, passwd, host, port = parse_args(uri)
    try:
        if dbtype.lower() == "mysql":
            dbc = MysqlConnector(host, uname, passwd, port)
        elif dbtype.lower() == "mssql":
            dbc = MSsqlConnector(host, uname, passwd, port)
        elif dbtype.lower() == "oracle":
            pass
        else:
            print("[!]DB Type not Supported")
            sys.exit(-1)
    except ConnectionRefusedError:
        print("[!]Connection error")
        sys.exit()
    shell = shell_loop(dbc)
    shell.send(None)
    while True:
        print("\n> ", end='')
        shell.send(input(""))
  
  
if __name__ == "__main__":  
    main()