import sys
import urllib
import urllib2

endpoint = sys.argv[1]

while True:
    line = raw_input("$ ")
    line = line.strip()
    if line == "quit" or line == "exit":
        sys.exit(0)
    encline = urllib.quote(line, safe='')
    response = urllib2.urlopen(endpoint + "?c=" + encline)
    data = response.read()
    print data
