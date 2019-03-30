#encoding:utf-8
import re
import os


#可疑加密文件，请注意甄别

rule = r'(\\x65\\x76\\x61\\x6C\\x28\\x67\\x7A\\x75\\x6E\\x63\\x6F\\x6D\\x70\\x72\\x65\\x73\\x73.{0,15})';
rule2 = r'(chr\(\d{1,3}\)\.chr\(\d{1,3}\)\.chr\(\d{1,3}\)\.chr\(\d{1,3}\))';

def Check(filestr,filepath):

    #php zend一句话  caidao.php
    if filestr[:4]=='Zend':
        if os.path.getsize(filepath)==178:
            return (('Zend Encode',),),'zend加密php一句话后门'

    elif 'x65' in filestr:
        result = re.compile(rule).findall(filestr)
        if len(result)>0:
            return ((result,),),'可疑：eval(gzuncompress加密方式的十六进制字符串'

    elif 'chr' in filestr:
        result = re.compile(rule2).findall(filestr)
        if len(result)>0:
            return ((result,),),'可疑：chr重复加密字符串（超过4个），请查看'


    #其他后门判断c
    return None
