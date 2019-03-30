#include <stdio.h>
#include <string.h>




	
unsigned char code[]=\
"\x48\x31\xff\x48\x31\xc0\xb0\x3c\x0f\x05";

main()
{
	printf("Shellcode Length:%d\n Bytes",(int)strlen(code));
	int (*ret)()=(int(*)())code;
	ret();
}

/*

global _start

section .text:

_start:
	xor rdi,rdi
	xor rax,rax
	mov al,60
	syscall
	
*/
