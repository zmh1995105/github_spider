shellman
========

Use a php webshell to get a bash like shell session with extras.

Dependancies
========
Terminal colors:

	pip install termcolor

Usage
========
First of all, generate your PHP shell with:

	./shellman.py -g

Upload your shell to the server and connect with:

	./shellman -u example.com/shell.php

Files can be uploaded with:
	
	upload full/path/to/local/file (remotefile)

(if you dont specify remotefile, it will be uploaded to your current pwd)
	
Files can be downloaded with:
	
	download remotefile (full/path/to/local/file)

(if you dont specify full/path/to/local/file, it will be downloaded to /tmp)

Download the contents of a directory recursively:

	getdir remotedir

Download all webpages:

	getpages

Test local kernel version for priv-esc thanks to Bernardo Damele A. G. :
	
	getprivs

Basic linux enum:

	getenum

Self-Destruct PHP Shell

	selfdestruct

Text editors vi, nano and pico can be used to edit files on the remote server in the normal way:

 	vi index.php
 	nano index.php
 	pico index.php
 	emacs index.php
	
Shellman can be tested by putting shell.php in /var/www and starting apache.
if you don't specify a url the software will assume testing and connect to http://localhost/shell.php 

	usage: ./shellman.py -u URL

	optional arguments:
	  -h, --help         show this help message and exit
	  -u URL, --url URL  PHP Shell URL
	  -g, --generate     Generate PHP shell and password

	extra commands:
	  upload        - upload a file
	  download	    - download a file
	  getprivs      - priv-esc checker
	  getenum       - basic linux enum
	  getpages      - download all webpages
	  getdir        - download a directory recursively
	  selfdestruct  - delete php shell
	  c or clear    - clear the screen
	  e or exit     - exit shellman
