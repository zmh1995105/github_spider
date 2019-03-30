#!/bin/bash

echo ""
echo "███████╗██╗  ██╗███████╗██╗     ██╗  ████████╗██████╗ ███████╗ █████╗ ████████╗ ██████╗ ██████╗ "
echo "██╔════╝██║  ██║██╔════╝██║     ██║  ╚══██╔══╝██╔══██╗██╔════╝██╔══██╗╚══██╔══╝██╔═══██╗██╔══██╗"
echo "███████╗███████║█████╗  ██║     ██║     ██║   ██████╔╝█████╗  ███████║   ██║   ██║   ██║██████╔╝"
echo "╚════██║██╔══██║██╔══╝  ██║     ██║     ██║   ██╔══██╗██╔══╝  ██╔══██║   ██║   ██║   ██║██╔══██╗"
echo "███████║██║  ██║███████╗███████╗███████╗██║   ██║  ██║███████╗██║  ██║   ██║   ╚██████╔╝██║  ██║"
echo "╚══════╝╚═╝  ╚═╝╚══════╝╚══════╝╚══════╝╚═╝   ╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝   ╚═╝    ╚═════╝ ╚═╝  ╚═╝"
echo ""
echo "*----------------------------------------------------------------------------------------------*"
echo "*      SHELLtreator Versión 1.0   |   Juampa UnD3sc0n0c1d0 Rodríguez   |   Moebiusec Team      *"
echo "*----------------------------------------------------------------------------------------------*"
echo ""

echo "-Indica el nombre del Diccionario que deseas usar:"
read VarShells
echo ""
echo "-Indica la URL (PATH) de tu objetivo:"
read Ruta
echo ""

	Min=1
	mkdir TEMP
	cd TEMP
	IFS=$'\n'
	echo "LISTA DE SHELL ENCONTRADAS"
	echo "-------------------------------------------"
		for Dics in $(cat ../$VarShells);
		do curl -s "$Ruta$Dics" -D Fichero$Min > /dev/null;
		CatFichero=$(cat Fichero$Min)
			if [[ $CatFichero = *OK* ]];
			then
				echo $Min: $Ruta$Dics
				Min=$(($Min+1))
			fi
		done
	echo ""
	rm -r ../TEMP
