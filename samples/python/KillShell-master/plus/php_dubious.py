#!/usr/bin/python2.7
#coding:utf-8

import re


__author__ = 'jincon'

rule = r'([include|require].*\(?PACK\()';
rule2 = r'([\'|"]#[\'|"]\s*\^\s*[\'|"]\|[\'|"])';
# rule3='(preg_replace[\s\n]{0,10}\([\s\n]{0,10}((["\'].{0,15}[/@\'][is]{0,2}e[is]{0,2}["\'])|\$[a-zA-Z_][\w"\'\[\]]{0,15})\s{0,5},\s{0,5}.{0,40}(\$_(GET|POST|REQUEST|SESSION|SERVER)|str_rot13|urldecode).{0,30})'
# rule4='(call_user_func[\s\n]{0,25}\(.{0,25}\$_(GET|POST|REQUEST).{0,15})'
# rule5=r'(array_map[\s\n]{0,20}\(.{1,5}(eval|assert|ass\\x65rt).{1,20}\$_(GET|POST|REQUEST).{0,15})'

def Check(filestr,filepath):
    if 'PACK' in filestr: #先查询下，然后正则，效率高了很多。
        result = re.compile(rule).findall(filestr)
        if len(result)>0:
            for key in result:
                return ((key,),),'require PACK 非法引用加密字符串'

    if '^' in filestr: #先查询下，然后正则，效率高了很多。
        result = re.compile(rule2).findall(filestr)
        if len(result)>0:
            for key in result:
                return ((key,),),'"#"^"|" 后门特征，可疑字符串，注意查看'

    # if 'preg_replace' in filestr:
    #     result = re.compile(rule3).findall(filestr)
    #     if len(result)>0:
    #         return result,'preg_replace后门'
    #
    # if 'call_user_func' in filestr:
    #     result = re.compile(rule4).findall(filestr)
    #     if len(result)>0:
    #         return result,'call_user_func后门'
    #
    # if 'array_map' in filestr:
    #     result = re.compile(rule).findall(filestr)
    #     if len(result)>0:
    #         return result,'array_map后门'

    return None
