#include <stdio.h>
#include <string.h>



	
unsigned char code[]=\
"\xeb\x1a\x1c\x5e\x48\x31\xc0\x48\x31\xff\x48\x31\xd2\xb0\x01\x40\xb7\x01\xb2\x0b\x0f\x05\xb0\x3c\x48\x31\xff\x0f\x05\xe8\xe1\xff\xff\xff\x48\x65\x6c\x6c\x6f\x20\x57\x6f\x72\x6c\x97\x64";

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
	jmp call_shellcode				;jumps to the call shellcode

	shellcode:
		pop rsi					;this pops the address of the "hello world" into rsi helping us determine the address dynamically 
		xor rax,rax
		xor rdi,rdi
		xor rdx,rdx
		mov al,1
		mov dil,1
		mov dl,11
		syscall

		mov al,60
		xor rdi,rdi
		syscall

	call_shellcode:					;this executes the "call shellcode" instruction
		call shellcode				;the call instruction stores the address of the next instruction in the stack
		helloWorld: db "Hello World"
		
*/
