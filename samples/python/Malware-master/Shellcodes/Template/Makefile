FORMAT="elf64"
NASM_FILE="shelcode.nasm"
C_FILE="shellcode.c"
OBJ_FILE="shellcode.o"
SHELLCODE_OUTPUT="shellcode"
ASM_OUTPUT="shellcode_asm"

all: shellcode assemble clean

shellcode: $(C_FILE)
        gcc -fno-stack-protector -z -execstack $(C_FILE) -o $(SHELLCODE_OUTPUT)

assemble: $(NASM_FILE)
        nasm -f $(FORMAT) $(NASM_FILE) -o $(OBJ_FILE)
        ld $(OBJ_FILE) -o $(ASM_OUTPUT)

clean:
        rm *.o
