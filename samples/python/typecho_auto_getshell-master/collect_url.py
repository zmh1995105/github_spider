# coding:utf-8
import sys,os,re,requests
from bs4 import BeautifulSoup as bs

# 爬取https://www.zoomeye.org的搜索结果
# 定义变量
page = 1
countrys = sys.argv[1]  # 如美国：US
target = []
alive_time = []
base_url = "https://www.zoomeye.org/searchResult"
url = base_url+"?q=typecho +after:\"2017-01-01\"+before:\"2018-01-01\"+country:"+'\"'+countrys+'\"'+"&t=all" 
print(url)
headers={'User-Agent':'Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko','Cookie':'__jsluid=890d078d5b0d92d3878be05f95ece6f8; Hm_lvt_3c8266fabffc08ed4774a252adcb9263=1518830952,1518832695; Hm_lpvt_3c8266fabffc08ed4774a252adcb9263=1518947107; __jsl_clearance=1518954536.863|0|fvvZ91jjGG1zRaPev51B4XsU7XE%3D'}

# 定义一个写入target的函数
def write(target,country,alive_time):
    try:
        with open('target.txt','a') as f:
            f.write(target)
            f.write('\t')
            f.write(country)
            f.write('\t')
            f.write(alive_time)
            f.write('\n')
    except:
        print('target写入错误')

#处理页面内容
def get_base(url,headers):
    try:
        get_base = requests.get(url,headers=headers)
        get_base.raise_for_status()
        print(get_base.status_code)
        url_soup = bs(get_base.content,'html.parser')
        print(url_soup)
        return url_soup
    except:
        print('get_base error')

# get_base = requests.get(url,headers=headers)
# print(get_base.raise_for_status())


# get_base = requests.get(url,headers=headers)
# url_soup = bs(get_base.content,'lxml')
url_soup = get_base(url,headers)
for a_content in url_soup.select('.search-result-item-info'):
    # a_content.a['class']='search-result-item-title'
    target = re.findall(r'href="http://(?:[0-9]{1,3}\.){3}[0-9]{1,3}" target',str(a_content.a))
    # time = a_content.select('p[class="search-result-icon-time"]')
    a_content.a['class'] = 'search-result-icon-time'
    alive_time = re.findall(r'\d{4}-\d{2}-\d{2} \d{2}:\d{2}',str(a_content.a))
    write(target,content,alive_time)







