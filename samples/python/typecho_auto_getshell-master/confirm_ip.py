# -*- coding:utf-8 -*-
import requests,re
from bs4 import BeautifulSoup as bs


# 国内ip验证模块,采用：http://ip.chinaz.com
def confirm_ip(url):
    base_url = "http://ip.chinaz.com"
    find_url = base_url + "/" + url
    print(find_url)
    referer = base_url
    headers = {
        'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36',
        'Referer': referer
    }
    try:
        responce = requests.get(find_url)
        print(responce.status_code)
        soup1 = bs(responce.content, 'html.parser')
        # pattern = r'<span class="Whwtdhalf w15-0"`>([0-9]{1,3}\.){3}[0-9]{1,3}</span>'
        # match = re.match(pattern,responce.content)
        lists = soup1.select('p[class="WhwtdWrap bor-b1s col-gray03"] span[class="Whwtdhalf w50-0"]')
        para = r'<span class="Whwtdhalf w50-0">(.+?)</span>'
        local = re.findall(para,str(lists[0]))
        final = url.strip() + " " + str(local[0]).strip()
        print(final)
        return final


    except:
        print("requests error2")

# 从文件读取typecho网站域名
def get_file():
    try:
        with open('domain.txt', 'r') as f:
            for url in f.readlines():
                url = str(url).strip()
                final = confirm_ip(url)
                write_target(final)
    except:
        print("get_file error")

#url写入模块
def write_target(final):
    try:
        with open('target_url.txt', 'a') as f:
            f.write(final)
            f.write('\n')
    except:
        print("write_target error")
get_file()


# 判断是否为国内
