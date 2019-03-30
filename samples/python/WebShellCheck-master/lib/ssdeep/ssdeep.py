import os
import sys
import csv
import tempfile
import random
import time
import string

def ssdeep_dir(dir_path):
    cmd = 'ssdeep -t 50 -c -sm /home/cunny/graduate/php.ssdeep -r '+dir_path
    reponse = os.popen(cmd).read()
    reader = csv.reader(reponse.split('\n'), delimiter=',')
    res = []
    for row in reader:
        if len(row) != 0:
            if int(row[-1]) <= 50 :
                file_type = 'N'
            elif int(row[-1]) >= 75 :
                file_type = 'W'
            else:
                file_type = 'O'
            #print(row)
            tmp = {'file_type': file_type, 'file_path':row[0] }
            res.append(tmp)
        else:
            pass
    return res


def ssdeep_file(code):
    randstr = ''.join([random.choice(string.ascii_lowercase) for _ in range(16)])
    file_path = os.path.join(tempfile.gettempdir(),
                                  '{}_ssdeep_{}.txt'
                                  .format(randstr, int(time.time())))
    open(file_path,'wb').write(code.encode('utf-8'))
    cmd2 = '''sed -i 's/\\r//g' %s'''%file_path
    #print(cmd2)
    os.popen(cmd2)
    cmd = 'ssdeep -t 50 -c -s -bm /root/WebServer/php.ssdeep '+file_path
    #print(cmd)
    reponse = os.popen(cmd).read()
    #print(reponse)
    reader = csv.reader(reponse.split('\n'), delimiter=',')
    tmp = ''
    for row in reader:
        if len(row) != 0:
            if int(row[-1]) <= 50 :
                file_type = 'N'
            elif int(row[-1]) >= 75 :
                file_type = 'M'
            else:
                file_type = 'E'
            tmp = file_type
        else:
            pass
    return tmp

def reduce_dict(dicts):
    l = []
    l.append(dicts[0])
    for i in dicts:
        k = 0
        for j in l:
              if i['file_path'] != j['file_path']:
                  k=k+1
              else:
                  break
              if k == len(l):
                  #print(i)
                  l.append(i)
    return l    


#if __name__ == '__main__':
#    lists = ssdeep_dir(sys.argv[1])
#    for i in reduce_dict(lists):
#        print(i)
        #print(i)
#def ssdeep_file(file_path):

# print(ssdeep_file('''<?php 
# $a='lave'; 
# $b='($_POST[h])'; 
# $a=strrev($a); 
# @assert($a.$b); 
# ?>
# '''))
