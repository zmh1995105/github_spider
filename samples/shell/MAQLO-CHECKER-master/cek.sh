#!/bin/bash

clear
header(){
cat << "EOF"
  __  __          ____  _      ____  
 |  \/  |   /\   / __ \| |    / __ \ 
 | \  / |  /  \ | |  | | |   | |  | |
 | |\/| | / /\ \| |  | | |   | |  | |
 | |  | |/ ____ \ |__| | |___| |__| |
 |_|  |_/_/    \_\___\_\______\____/ 

		MAQLO CHECKER

EOF
}
MAaQLo0o0o0o0o0o0o0o0ooo0ooooooo0o0o00o00o0oooo0o0o0o0o0ooo000oo0o0o0oo00o(){
	# EDIT A WORD DEFACE
	kata1="pwneds"
	kata2="hacked"
	kata3="touched"
	kata4="pwned"
	kata5="defaced"
	
	M4QLo0o0o0o0o0o0o0o0o0o0o0o0o0o000o00o00o0o0o0o0o0o0ooooooooooooooooooo=$1
	printf "    Defaced ... "
	M4QLo0o0o0o0o0o0o0o0o0o0o0o0o0o000o00o00o0o0o0o0o0o0ooo000000oo00o=$(echo $M4QLo0o0o0o0o0o0o0o0o0o0o0o0o0o000o00o00o0o0o0o0o0o0ooooooooooooooooooo | grep -Po "(?<=://)[^/]*")
	M4QLo0o0o0o0o0o0o0o0o0o0o0o0o0o000o00o00o0o0o0o0o0o0ooo000oo0o0o0oo00o=$(curl -s "$M4QLo0o0o0o0o0o0o0o0o0o0o0o0o0o000o00o00o0o0o0o0o0o0ooo000000oo00o" -L)
	M4QLo0o0o0o0o0o0o0o0o0o0o0o0o0o000o00o00o0oooo0o0o0o0o0ooo000oo0o0o0oo00o=$(echo $M4QLo0o0o0o0o0o0o0o0o0o0o0o0o0o000o00o00o0o0o0o0o0o0ooo000oo0o0o0oo00o | tr [:upper:] [:lower:])
	if [[ $M4QLo0o0o0o0o0o0o0o0o0o0o0o0o0o000o00o00o0oooo0o0o0o0o0ooo000oo0o0o0oo00o =~ "${kata1}" ]] || [[ $M4QLo0o0o0o0o0o0o0o0o0o0o0o0o0o000o00o00o0oooo0o0o0o0o0ooo000oo0o0o0oo00o =~ "${kata2}" ]] || [[ $M4QLo0o0o0o0o0o0o0o0o0o0o0o0o0o000o00o00o0oooo0o0o0o0o0ooo000oo0o0o0oo00o =~ "${kata3}" ]] || [[ $M4QLo0o0o0o0o0o0o0o0o0o0o0o0o0o000o00o00o0oooo0o0o0o0o0ooo000oo0o0o0oo00o =~ "${kata4}" ]] || [[ $M4QLo0o0o0o0o0o0o0o0o0o0o0o0o0o000o00o00o0oooo0o0o0o0o0ooo000oo0o0o0oo00o =~ "${kata5}" ]]; then
		printf "TRUE\n"
		printf "    Skip\n\n"
		echo "$M4QLo0o0o0o0o0o0o0o0o0o0o0o0o0o000o00o00o0o0o0o0o0o0ooo000000oo00o -> Hacked" >> Defaced.txt
	else
		printf "FALSE\n"
		printf "    Checking Shell ... "
		M4QLo0o0o0o0o0o0o0o0ooo0ooooooo0o0o00o00o0oooo0o0o0o0o0ooo000oo0o0o0oo00o=$(curl -s -I "$M4QLo0o0o0o0o0o0o0o0o0o0o0o0o0o000o00o00o0o0o0o0o0o0ooooooooooooooooooo")
		if [[ $M4QLo0o0o0o0o0o0o0o0ooo0ooooooo0o0o00o00o0oooo0o0o0o0o0ooo000oo0o0o0oo00o =~ "200 OK" ]]; then
			printf "FOUND\n\n"
			echo "$M4QLo0o0o0o0o0o0o0o0o0o0o0o0o0o000o00o00o0o0o0o0o0o0ooooooooooooooooooo" >> Shells.txt
		else
			printf "NOT FOUND\n\n"
		fi
	fi
}

if [ -z $1 ]; then
	header
	printf "\n To Use : $0 <LIST.txt>\n"
	exit 1
fi

header

for M4QLo0o0o0o0o0o0o0o0o0o0o0o0o0o000o00o00o0o in $(cat $1); do
	MaMaQlL0o0o0o0o0o0o0o0o0o0o00o0oo0o0o00o0oo=$(echo $M4QLo0o0o0o0o0o0o0o0o0o0o0o0o0o000o00o00o0o | grep -Po "(?<=://)[^/]*")
	printf "[=] Checking http://$MaMaQlL0o0o0o0o0o0o0o0o0o0o00o0oo0o0o00o0oo/\n"
	MAaQLo0o0o0o0o0o0o0o0ooo0ooooooo0o0o00o00o0oooo0o0o0o0o0ooo000oo0o0o0oo00o $M4QLo0o0o0o0o0o0o0o0o0o0o0o0o0o000o00o00o0o
done
