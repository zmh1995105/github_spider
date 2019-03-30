import sys

def print_usage(arg0):
    sys.stderr.write('Usage: %s new_sha_file_name base_sha_file_name\n' %arg0)
    
if len(sys.argv) < 3:
    print_usage(sys.argv[0])
    sys.exit(1)

base_hash_file = open(sys.argv[2], "r")
hash_list = []
for l in base_hash_file:
    flds = l.split(' ')
    if flds[0] not in hash_list:
        hash_list.append(flds[0])
        
new_hash_file = open(sys.argv[1], "r")
for l in new_hash_file:
    flds = l.split(' ')
    if flds[0] in hash_list:
        print ' '.join(flds[2:]),
    else:
        hash_list.append(flds[0])
        
    
