import sys

inname = sys.argv[1]
outname = sys.argv[2]

data = None
with open(inname, 'r') as fh:
    data = fh.read()
data = data.strip()
with open(outname, 'w') as fh:
    fh.write(data.decode('base64'))
