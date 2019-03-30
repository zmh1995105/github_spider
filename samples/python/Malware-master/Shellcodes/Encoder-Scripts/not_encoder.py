#! /bin/python





original_shellcode=("Enter the Shellcode here")

encoded_shellcode_format1=[]
encoded_shellcode_format2=[]


for byt in bytearray(original_shellcode):
	xor=~byt
	xor="%02x" %(xor & 0xff)                    #to account for the negative values that might be generated
	xor1="\\x" + xor
	xor2="0x" + xor +","
	encoded_shellcode_format1.append(xor1)
	encoded_shellcode_format2.append(xor2)

print("Fromat 1:\n")

print''.join(encoded_shellcode_format1)

print("\n\n\n")

print("Format 2:\n")
print''.join(encoded_shellcode_format2)

print("\n")
print("Length:" +str(len(bytearray(original_shellcode))))
