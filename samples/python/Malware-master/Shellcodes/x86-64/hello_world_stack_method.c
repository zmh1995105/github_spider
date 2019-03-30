#include <stdio.h>
#include <string.h>



	
unsigned char code[]=\
"\x48\x31\xc0\x48\x31\xff\x48\x83\xc0\x01\x48\x83\xc7\x01\x68\x6f\x72\x6c\x64\x48\xbb\x68\x65\x6c\x6c\x6f\x20\x77\x00\x53\x48\x89\xe6\x66\xba\x0b\x00\x0f\x05\xb0\x3c\x48\x31\xff\x0f\x05";

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
	xor rax,rax
	xor rdi,rdi
	add rax,1
	add rdi,1
	push 0x646c726f
	mov rbx,0x77206f6c6c6568
	push rbx
	mov rsi,rsp
	mov dx,11
	syscall	


	mov al,60
	xor rdi,rdi
	syscall
*/

