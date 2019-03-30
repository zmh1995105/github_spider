#! /bin/sh


var=$(for i in `objdump -d <object file> | tr '\t' ' ' | tr ' ' '\n' | egrep '^[0-9a-f]{2}$' ` ; do echo -n "\x$i" ; done)
var2="\"$var\";"
sed -i '/\x/d' <shellcode.c>
sed "8a\
`echo $var2`" <shellcode.c> > temp
mv temp <shelcode.c>

