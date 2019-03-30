import requests
import json


class zoomeye:
    def __init__(self, keyword, page):
        self.username = ''
        self.password = ''
        self.access_token = ''
        self.keyword = keyword
        self.page = int(page) + 1
        self.targets = []

    def get_access_token(self):
        login_url = "https://api.zoomeye.org/user/login"
        data = '{"username": "%s", "password": "%s"\
        }' % (self.username, self.password)
        r = requests.post(login_url, data=data)
        self.access_token = r.text.split(":")[1][2:-2]
        return self.access_token

    def get_info(self):
        if not self.access_token:
            self.get_access_token()
        info_url = "https://api.zoomeye.org/resources-info"
        header = {"Authorization": "JWT " + self.access_token}
        r = requests.get(info_url, headers=header)
        print r.text

    def run(self):
        if not self.access_token:
            self.get_access_token()
        for n in range(1, self.page):
            search_url = "https://api.zoomeye.org/host/search?query=%s&page=%s\
            " % (self.keyword, str(n))
            header = {"Authorization": "JWT " + self.access_token}
            r = requests.get(search_url, headers=header)
            result = json.loads(r.text)
            for i in result['matches']:
                target = i['ip'] + ":" + str(i['portinfo']['port'])
                # print target
                self.targets.append(target)
        return self.targets


if __name__ == '__main__':
    p = zoomeye("jboss", "1")
    # p.get_access_token()
    p.get_info()
    #p.run()
