# /usr/bin/env python
# encoding: utf-8
"""
@author: zmh
@license: (C) Copyright 2018-2018, Jason_0211. All rights reserved.
@contact: Jason_zhengminghao@163.com
@software: PyCharm
@file: main.py
@time: 2019/2/28 17:31
@desc: A spider used to scrape proxy pool
"""
import codecs
import random
import requests
import time
from proxies_pool import proxy_list
from pyquery import PyQuery as pq

from user_agent_pool import user_agents
from gevent.pool import Pool
from gevent import monkey
monkey.patch_all()


class ProxySpider(object):
    def __init__(self, filename):
        self.url = "https://www.kuaidaili.com/free/inha/"
        self.filename = filename
        self.proxies = []
        self.f = codecs.open(self.filename, "w", "utf-8")
        self.headers = {
                    'User-Agent': random.choice(user_agents),
                    'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                    'Accept-Encoding': 'gzip,deflate,sdch',
                    'Accept-Language': 'zh-CN,zh;q=0.8'
                }

    def func(self, page):
        request_url = self.url + str(page)

        try:
            r = requests.get(request_url, headers=self.headers, proxies={"http": random.choice(proxy_list)}, timeout=3)
            assert r.status_code == 200
        except (AssertionError, requests.ConnectionError):
            time.sleep(2)
            self.func(page)
            return

        d = pq(r.content)
        items = d('table.table-striped tbody tr')
        for item in items:
            i = pq(item)
            ip = i("td")[0].text
            port = i("td")[1].text
            line = "'{}:{}',\n".format(ip, port)
            self.proxies.append(line)
            print(line)
            self.f.write(line)

    def run(self):
        self.f.write("proxy_list = [\n")
        p = Pool(20)
        for i in range(600, 650):
            p.apply_async(self.func, (i,))
        p.join()
        self.f.write("]")
        self.f.close()


if __name__ == '__main__':
    filename = "proxies_pool.txt"
    spider = ProxySpider(filename)
    spider.run()

