# /usr/bin/env python
# encoding: utf-8
"""
@author: zmh
@license: (C) Copyright 2018-2018, Jason_0211. All rights reserved.
@contact: Jason_zhengminghao@163.com
@software: PyCharm
@file: main.py
@time: 2019/2/28 17:31
@desc: A spider used to scrape codes from github
"""
import gc
import json
import random
import re
import urllib2
import zipfile
import codecs
import requests
import os
import time
import shutil

from gevent.pool import Pool
from gevent import monkey
monkey.patch_all()

from proxies_pool import proxy_list
from user_agent_pool import user_agents

DIR = "/home/wwwroot/default/samples"


class Spider(object):
    def __init__(self, language, keyword):
        self.language = language
        self.keyword = keyword
        self.headers = {
            'User-Agent': random.choice(user_agents),
            'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'Accept-Encoding': 'gzip,deflate,sdch',
            'Accept-Language': 'zh-CN,zh;q=0.8'
        }
        self.repo_list = list()
        self.total_pages = 1
        self.md_lines = list()

        self.dir_name = os.path.join(DIR, self.language)

        os.mkdir(self.dir_name)

    def run(self):
        print("starting to get repos of %s ..." % self.language)
        total_count = self.get_total()
        total_page = total_count // 100
        for i in range(1, total_page+2):
            self.get_repo(i)
        self.save_md(total_count)

        print("starting to download repos of %s..." % self.language)
        self.download(list(set(self.repo_list)), self.dir_name)

    def get_response(self, request_url, params=None):
        try:
            proxy = random.choice(proxy_list)
            r = requests.get(request_url, params, headers=self.headers,
                             proxies={"http": proxy}, timeout=5)
            assert r.status_code == 200
        except (AssertionError, requests.ConnectionError):
            time.sleep(1)
            return self.get_response(request_url, params)
        return r.content

    def get_total(self):
        request_url = "https://api.github.com/search/repositories"
        params = {
            "q": "{}+language:{}".format(self.keyword, self.language),
            "sort": "stars",
            "order": "desc"
        }
        content = self.get_response(request_url, params)
        d = json.loads(content)
        total_count = d["total_count"]
        return total_count

    def get_repo(self, page):
        request_url = "https://api.github.com/search/repositories"
        params = {
            "q": "{}+language:{}".format(self.keyword, self.language),
            "page": "{}".format(page),
            "per_page": "100",
            "sort": "stars",
            "order": "desc"
        }
        content = self.get_response(request_url, params)
        d = json.loads(content)
        items = d["items"]

        for i in items:
            title = i["full_name"]
            url = i["html_url"]
            date_time = i["updated_at"]
            description = i["description"]
            default_branch = i["default_branch"]
            line = u"* [{title}]({url})|{date_time}|: {description}\n". \
                format(title=title, date_time=date_time, url=url, description=description)
            print(line)
            self.md_lines.append(line)
            self.repo_list.append(title + "*" + default_branch)

    def save_md(self, total_count):
        filename = os.path.join(self.dir_name, "{}.md".format(self.language))
        with codecs.open(filename, "a", "utf-8") as f:
            line = "*******keyword: {k}, language: {l}, total_count: {t}*******\n\n". \
                format(k=self.keyword, l=self.language, t=total_count)
            f.write(line)
            for line in self.md_lines:
                f.write(line)

    def download(self, project_list, directory):
        if not os.path.exists(directory):
            os.mkdir(directory)

        pool = Pool(20)
        for i in project_list:
            l = i.split("*")
            title = l[0]
            branch_name = l[1]
            print('downloading ' + title + ' to ' + directory + '/')
            pool.apply_async(self.git_clone, (title, directory, branch_name))

        print('downloading please don\'t stop it')
        pool.join()

    def git_clone(self, title, path, branch_name):
        username, project_name = re.match('(.+)/(.+)', title).groups()
        url = 'https://codeload.github.com/{}/{}/zip/{}'.format(
            username, project_name, branch_name)
        filename = path + '/' + project_name
        zipfile_name = filename + "_" + username + '.zip'
        try:
            data = urllib2.urlopen(url)
            with open(zipfile_name, 'wb') as f:
                f.write(data.read())
        except Exception as e:
            print(e)
            return

        print("extracting %s" % zipfile_name)
        with zipfile.ZipFile(zipfile_name, 'r') as f:
            f.extractall(path)
        os.remove(zipfile_name)


if __name__ == '__main__':
    if os.path.exists(DIR):
        shutil.rmtree(DIR)
    os.mkdir(DIR)
    languages = ["php", "python", "javascript", "java", "html", "asp", "go", "shell", "perl", "c#"]
    keyword = "webshell"
    for l in languages:
        spider = Spider(l, keyword)
        spider.run()
        del spider
        gc.collect()





