#include <stdio.h>
#include <string.h>



	
unsigned char code[]=\
"\xeb\x0b\x48\x65\x6c\x6c\x6f\x20\x57\x6f\x72\x6c\x78\x64\x48\x31\xc0\x48\x31\xc0\x48\x31\xd2\x48\x31\xff\xb0\x01\x48\x83\xc7\x01\x48\x8d\x35\xdf\xff\xff\xff\x48\x83\xc2\x0b\x0f\x05\xb0\x3c\x48\x31\xff\x0f\x05";

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

	jmp real_start				;this allows us to eliminate the null bytes in the shellcode since the location of hello_world string is above
	hello_world: db "Hello World"		;lea instruction it does not give us null bytes
	
real_start:
	xor rax,rax
	xor rdx,rdx
	xor rdi,rdi
	mov al,1
	add rdi,1
	lea rsi,[rel hello_world]
	add rdx,11
	syscall

	mov al,60
	xor rdi,rdi
	syscall
	
*/

/*

global _start
default rel
section .text

_start:

	jmp real_start				;this allows us to eliminate the null bytes in the shellcode since the location of hello_world string is above
	hello_world: db "Hello World"		;lea instruction it does not give us null bytes
	
real_start:
	xor rax,rax
	xor rdx,rdx
	xor rdi,rdi
	mov al,1
	add rdi,1
	lea rsi,[hello_world]
	add rdx,11
	syscall

	mov al,60
	xor rdi,rdi
	syscall
	
*/

