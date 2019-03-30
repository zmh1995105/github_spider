#!/usr/bin/python
#!encoding:utf-8
import os
import sys
import getopt
import xml.dom.minidom
import re
import hashlib
import sqlite3
import datetime

database='./file/file.db'
conn=sqlite3.connect(database)

def usage():
    print 'Usage:[[-f|target file],[-e|regex String],[-c|regex xml file],[-d|database file],[-h,--help|usage],[-o,--ouput|ouput way]]'


'get regex string from xml file .'
def read_regex_from_xml(xml_file):
    DOMTree=xml.dom.minidom.parse(xml_file)
    collection=DOMTree.documentElement
    regexs=collection.getElementsByTagName('regex_key')
    regex_string='('
    for regx in regexs:
        if regx.getElementsByTagName('enable')[0].childNodes[0].data == '1':
            temp=regx.getElementsByTagName('value')[0].childNodes[0].data.replace(',','|')
            temp+='|'
            regex_string+=temp
    regex_string=regex_string[:-1]
    regex_string+=")"
#    print 'The regex string is %s in the method!' % regex_string
    return regex_string

def scan_file(file_name,regx,result):
    if os.path.isfile(file_name) and os.access(file_name,os.R_OK):
        file_name=os.path.abspath(file_name)
        if not is_file_leggle(file_name,regx):
            result.append(file_name)
    elif os.path.isdir(file_name) and os.access(file_name,os.R_OK):
        temp_str='Scanning folder:%s' % os.path.abspath(file_name)
        output_to_line(temp_str)
        sys.stdout.write('\n')
        for item in os.listdir(file_name):
            item_file=os.path.join(file_name,item)
            scan_file(item_file,regx,result)

def output_to_line(outstr):
    outstr+='       \r'
    sys.stdout.write(outstr)
    sys.stdout.flush()

def caclu_md5(file_name):
    if os.path.isfile(file_name) and os.access(file_name,os.R_OK):
        m=hashlib.md5()
        with open(file_name,'r') as f:
            while True:
                data=f.read(10240)
                if not data:
                    break
                m.update(data)
        return m.hexdigest()
    return None

def data_init():
    conn=sqlite3.connect(database)
    sql="create table if not exists file_info (file_name text not null,file_md5 varchar(32) not null,updatetime datetime default current_timestamp,primary key(file_name,file_md5))"
    excute_sql(sql=sql)
    sql='create table if not exists webshell_info(webshell_id integer primary key autoincrement,file_name text not null,file_md5 varchar(32) not null,lastmodify date not null,findtime timestamp default current_timestamp)'
    excute_sql(sql=sql)

def select_sql(sql,data=()):
    return conn.execute(sql,data).fetchall()

def excute_sql(sql,data=()):
    if data:
        conn.executemany(sql,data)
    else:
        conn.execute(sql)
    conn.commit()


def is_file_leggle(file_name,regex):
    #print 'regex string is %s ' % regex
    pattern=re.compile(regex)
    result=True
    #print 'Scan file %s ' % file_name
#    if not (file_name.endswith('jsp') or file_name.endswith('java')):
#        return True
#    sql='select file_md5 from file_info where file_name=?'
#    param=((file_name,))
#    file_md5=caclu_md5(file_name)
#    if (file_md5,) in select_sql(sql=sql,data=param):
#        return True
    with open(file_name,'r') as open_file:
        temp=open_file.readline()
        while temp != '':
            #print temp
            if pattern.match(temp):
 #               print temp
                result=False
                break
            temp=open_file.readline()
    if result:
        sql='insert into file_info(file_name,file_md5) values (?,?)'
#        param=((file_name,file_md5),)
    else:
        sql='insert into webshell_info(file_name,file_md5,lastmodify) values (?,?,?)'
#        param=((file_name,file_md5,datetime.datetime.fromtimestamp(os.path.getmtime(file_name))),)
#    excute_sql(sql=sql,data=param)
    return result

def output(outputway,outputdata):
    if outputway in ('t','terminal'):
        print '\033[93m Possible webshell file(total:%d) is(please check the same folder if there are some other webshells):\n'%len(outputdata)
        for o in outputdata:
            print '\033[93m'+str(o)+'\033[0m'
    else:
        print 'Write result to file:%s' % outputway
        with open(outputway,'w') as f:
            f.write('Possible webshell file(total:%d) is(please check the same folder if there are some other wenshells):\n'%len(outputdata))
            for o in outputdata:
                f.write(o+'\n')

def main():
    opts,args=getopt.getopt(sys.argv[1:],'hf:e:c:o:',['help','output='])
    target_file=['./']
    regex_string='.*'
    regex_xml='./file/regex_demo.xml'
    outway='t'
    global database
    global conn
    for opt,value in opts:
        if opt=='-f':
            if value!='./':
                target_file.append(value)
        if opt=='-e':
            regex_string=value
        if opt=='-c':
            regex_xml=value
        if opt in ('-h','--help'):
            usage()
        if opt=='-d':
            database=value
            conn=sqlite3.connect(database)
        if opt in ('-o','--output'):
            print value
            outway=value
    if target_file==[]:
        print 'Target file empty!'
        usage()
        sys.exit(-1)
    if os.path.exists(regex_xml) and regex_string == '.*':
        regex_string+=read_regex_from_xml(regex_xml)
    regex_string+='.*'
    result=[]
    print 'Regex String is :%s ' % regex_string
    data_init()
    print 'Scaning......'
    for target in target_file:
        scan_file(target,regex_string,result)
    print '\033[91m Total %d possibile webshell. \033[0m' % len(result)
    output(outway,result)
    print 'Scan finished.'
if __name__=='__main__':
    main()
