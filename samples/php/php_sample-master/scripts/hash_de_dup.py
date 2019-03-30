import sys

def print_usage(arg0):
    sys.stderr.write('Usage: %s file_name\n' %arg0)
    
if len(sys.argv) < 2:
    print_usage(sys.argv[0])
    sys.exit(1)

hash_file = open(sys.argv[1], "r")
hash_list = []
for l in hash_file:
    flds = l.split(' ')
    if flds[0] in hash_list:
        print ' '.join(flds[2:]),
    else:
        hash_list.append(flds[0])
        
    
