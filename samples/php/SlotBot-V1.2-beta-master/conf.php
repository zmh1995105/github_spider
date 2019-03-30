<?php
/*
 *
 * @author Slotleet
 * @email Slotleet@gmail.com
 * @website Sec4ever.com
 */

// Database Information
$localhost = "localhost"; // DB Host Name
$username = "root"; // DB Username
$password = "root"; // DB Password
$dbname = "slotbot"; // DB name 

// Authentication, default credentials - admin:admin
$auth = 1;
$authuser ='admin';
$authpass ='6a4e012bd9583858a5a6fa15f58bd86a25af266d3a4344f1ec2018b778f29ba83be86eb45e6dc204e11276f4a99eff4e2144fbe15e756c2c88e999649aae7d94'; // hash('whirlpool', 'admin');

// Proxy (only Socks5) - Default TOR connection - 127.0.0.1:9050
$proxy = 0; // Enabel proxy
$proxyip = "127.0.0.1"; // Proxy ipaddress
$proxyport = "8080"; // Proxy port

// Misc
$nmap = ""; // Nmap executable directory for Scan module
$checksql = ""; // Determine whenever mysql connection should be checked
$pwn_http_method = "system"; // Determine php function being used in PWN and Shell module
$perpage = 5; // Show Zombies per page

