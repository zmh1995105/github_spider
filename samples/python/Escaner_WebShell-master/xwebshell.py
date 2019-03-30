#!/usr/bin/env python
# -*- coding: utf-8 -*- 
#
# VenCERT
#
# Autor: Miguel Marquez
# Departamento: Seguridad Logica
# Caracas, 18/10/17
#
# XWebShell V 1.0
#
#Escaner de webshell busca e imprime los modulos vulnerables de archivos potencialmente peligrosos escritos en php
#
#Comandos:
#
#1.- python xwebshell.py -h << informacion
#2.- python xwebshell.py -r /directorio/sub_directorio
# prerequisitos 
import os
import sys
#-------------------------------------------------------------
class Shell:
    def __init__(self, xArchivo, xRuta, xRutaActual):
        self.__archivo= xArchivo# archivo ext php
        self._ruta= xRuta
        self._rutaActual= xRutaActual
        self.__wShell= None
        self.__listarShell= list()
        self.__enumerarShell= list()
        self.__tipoShell=[
                             'exec(',
                             'system(',
                             'passthru(',
                             'shell_exec(',
                             'proc_open(',
                             'show_source(',
                             'popen('
                          ]#
#-------------------------------------------------------------
    def filtrar(self, lista, shell):
        suiche= True
        for i in range(0, len(lista)):
            buscar= shell.upper().find(lista[i].upper())
            if buscar != -1:
                suiche= False
        return suiche
#-------------------------------------------------------------
    def repetir(self, leer, index, obtener, contador):
        while(leer):
            leer= obtener.readline()
            #
            buscar= leer.upper().find(self.__tipoShell[index].upper())
            if buscar != -1:
                contador+=1
                #funcion evitar repetir
                if self.filtrar(self.__listarShell, self.__tipoShell[index]):# FUNCION
                    self.__listarShell.append(self.__tipoShell[index])
        return contador
#-------------------------------------------------------------
    def cosechar(self):
        for index in range(0, len(self.__tipoShell)):
            contador=0# cuenta los modulos tipo shell
            obtener= open(self._ruta,'r')# archivo ext php
            leer= obtener.readline()
            buscar= leer.upper().find(self.__tipoShell[index].upper())
            if buscar != -1:
                contador+=1
                #funcion evita repetir 
                if self.filtrar(self.__listarShell, self.__tipoShell[index]):# FUNCION
                    self.__listarShell.append(self.__tipoShell[index])
            contador= self.repetir(leer, index, obtener, contador) # FUNCION
            if contador != 0:# si encuentra alguna shell
                self.__enumerarShell.append(contador)
        
            obtener.close()# cierra
#-------------------------------------------------------------
    def imprimir(self):
        if self.__listarShell: #si la lista no esta vacia
            self.__wShell= self.__archivo
            info = os.stat(self._ruta)#obtiene estado del archivo
            peso = round(info.st_size/1024, 1)#obtine el tamaño
            print('\x1b[1;32;40m'+'SE ENCONTRO PRESUNTA WebShell!!!\n')
            print('\x1b[1;32;40m'+"NOMBRE: \t"+'\x1b[1;31;40m'+self.__archivo+" \t \t"+'\x1b[1;32;40m'+ str(peso)+" Kb" )
            print("\nMODULOS PHP:\n")
            for i in range(0,len(self.__listarShell)):
                limpiar= self.__listarShell[i].strip()
                limpiar+=' )'
                print('\x1b[1;32;40m'+'>> '+'\x1b[1;31;40m'+limpiar+'\x1b[1;32;40m'+' X '+'\x1b[1;31;40m'+str(self.__enumerarShell[i]))
            print('\x1b[1;32;40m'+'\nDIRECTORIO: '+'\x1b[1;34;40m'+self._ruta+'\n')
            print('\x1b[1;32;40m'+"--------------------------------VenCERT------------------------------------\n")
#-------------------------------------------------------------
    def actualizar(self, xWebShell):
        if self.__wShell != None:
            xWebShell.append(self.__wShell)
        return xWebShell
           
########################################################################################
class Escaner:
    def __init__(self, sRuta):
        self.__ruta= sRuta
        self.__listadoPhp= list()
        self.__wShell= list()
#-------------------------------------------------------------        
    def directorios(self):
        
        print('\x1b[1;34;40m'+"\nESCANEANDO...\n")
        for actualDir, subDir, archivos in os.walk(self.__ruta):#establecer la ruta
            for aPhp in archivos:
                if self.filtrar(aPhp):
                    rutaCompleta= os.path.join(actualDir, aPhp) #aPhp archivos php
                    self.__listadoPhp.append(aPhp)
                    #INSTANCIACION DE CLASE SHELL
                    estaShell= Shell(aPhp, rutaCompleta, self.__ruta)
                    estaShell.cosechar()
                    estaShell.imprimir()
                    self.__wShell= estaShell.actualizar(self.__wShell)
                    #print(rutaCompleta)#<<<< OJO
#-------------------------------------------------------------
    def filtrar(self, arch):
        arch= arch[len(arch)-4:len(arch)]
        suiche= False
        if '.PHP' == arch.upper():
            suiche= True
        return suiche
#-------------------------------------------------------------
    def iniciar(self):
        suiche= False
        if os.path.lexists(self.__ruta):
            os.chdir(self.__ruta)
            suiche= True
        else:
            print('\x1b[1;31;40m'+'NO SE ENCUENTRA EL DIRECTORIO: '+ self.__ruta)
        return suiche
#-------------------------------------------------------------
    def imprimir(self):
        if not self.__listadoPhp:
            print('\x1b[1;31;40m'+"NO SE ENCONTRARON ARCHIVOS CON EXTENCION (*.php) EN DIRECTORIO PROPORCIONADO: "+ self.__ruta)
        else:     
            if not self.__wShell:
                print('\x1b[1;31;40m'+"NO SE ENCONTRARON ( WebShells ) EN EL DIRECTORIO: "+self.__ruta)
########################################################################################
if __name__ == '__main__':

    if len(sys.argv) <= 3 and len(sys.argv) >=2:
        #Instaciación Clase Escaner
        if sys.argv[1] == '-r':
            try:
                XWebShell= Escaner(sys.argv[2])
                aux= XWebShell.iniciar()
                XWebShell.directorios()
                if aux: 
                    XWebShell.imprimir()
            except IndexError:
                print('\x1b[1;31;40m'+'\nERROR!!! NO INTRODUJO UNA RUTA, ESCRIBA -h PARA MAS INFORMACION\n')
                
        elif sys.argv[1] == '-h':
            print('\x1b[1;32;40m'+'\nINFORMACION\n')
            print('xwebshell.py: escaner de webshell busca e imprime los modulos vulnerables de archivos potencialmente peligrosos escritos en php')
            print('\nPrerequisitos: instalar python 3\n')
            print('Comando: \"-r\" ')
            print('Descripcion: introducir la ruta a escanear')
            print('Sentencia: python xwebshell.py -r /directorio/sub_directorio')
            print('ejemplo: python xwebshell.py -r /var/www\n\n')
        else:
            print('\x1b[1;32;40m'+'\nERROR!!! COMANDO INVALIDO, ESCRIBA -h PARA MAS INFORMACION\n')
    else:
        print('\x1b[1;31;40m'+'\nERROR!!! CANTIDAD DE ARGUMENTOS INVALIDA, ESCRIBA -h PARA MAS INFORMACION\n')
########################################################################################
