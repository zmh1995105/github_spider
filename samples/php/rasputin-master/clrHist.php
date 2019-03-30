<?php

session_start();

if ( !isset( $_SESSION['username'] ) ) {
        header( 'Location: login.html' );
}

unlink( 'commands.txt' );

header( 'Location: shell.php' );

?>
