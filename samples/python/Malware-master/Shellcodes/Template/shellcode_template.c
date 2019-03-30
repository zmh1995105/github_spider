#include <stdio.h>
#include <string.h>



unsigned char code[]=\
"Shellcode goes here";

main()
{
        printf("Shellcode Length:%d\n Bytes",(int)strlen(code));
        int (*ret)()=(int(*)())code;            //initialize a pointer to function and make it point to code
        ret();                                  //call the function
}
