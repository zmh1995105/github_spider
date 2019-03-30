# palone-webshell
Selfmade PHP webshell. Nothing special but I just didnt like public ones I found.

![Screenhot](https://i.imgur.com/enz93jV.png)
> Its pretty

# Why another webshell?

I wanted to play around with some vulnerable software on my server and all the webshells I found on github seemed fishy, bad or bloated as fuck. At least in my opinion. And when I dont find software that suits my taste I just make my own. 

# Is this special?

You can use multiple PHP commands to execute stuff instead of just one. Didn't see that featue a lot. Otherwise its nothing special at all.
It uses either:

- exec <- most stable one
- passthru 
- system 
- shell_exec 
- popen (live output!) <- doesnt't work on some webservers

There is also a shell_exec with a possible safe_mode bypass as mentioned [here](https://tools.cisco.com/security/center/viewAlert.x?alertId=11688)

If a server has blacklisted one but not the other, you can still gain code execution that way. 

Apart from that it uses GET parameters so you can invoke commands without using the form. Also its responsive... if you'd ever need that.

# Thats it. Use ethical!
