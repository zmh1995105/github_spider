 SlotBot 1.2 - ReadMe

#Agenda

Slotbot is a complex webshell manager written in PHP, which operate on web-based back-doors implemented by user himself.
Using prepared php back-doors, Slotbot will work as C&C trying to communicate with each back-doors.
Tool goes beyond average web-shell managers, since it delivers useful functions for scanning, exploiting and so on.
It is Slot-HTTP botnet, therefore it is called. Also, Slotbot allows you to perform various brute-force attacks on services such as ftp, ssh or databases.
All data about bots is stored in SQL database, ATM only MySQL is supported. TOR proxy is also supported, the goal was to create secure connection between C&C and backdoors; using SOCKS5, it is able to torify all connections between you and web server.
All configuration is stored in conf file.
Slotbot it's still under construction so i am aware of any potential bugs.
You will need any web server software; tested on Linux, Apache 2.2 and PHP 5.4.4. Fully written in PHP. 

V1.2

- replacing old MySQL system with MySQLi
- Adding Classes System's
- Adding Pagination for zombies
- Optimization
- Bug fixes
- Adding Login System
- Adding Private-key (Just securing our code)
- Fixing Pwn System (It was crashing after 30sec)




PS: It's now officially Powered By Sec4ever.com Forums
