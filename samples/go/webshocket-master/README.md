# WebSHocket

A Golang based webshell that uses websockets for the command channel

## Overview

This tool is heavily based on the [gorilla command example](https://github.com/gorilla/websocket/tree/master/examples/command).

I've made some minor modifications that: 

1. Hard-code `/bin/sh` as the command to bind to the websocket
2. Support running the server on a user-specified port
3. Embed the html content as b64 encoded string rather than using an external file (which is, arguably, more useful for red-teaming scenarios)

## Usage

1. Run the binary, specifying the port as a command-line argument: `./ws 8080`
2. Point a web browser at the IP address and port where the app is running (the app defaults to listening on every interface)
3. Type commands into the form, and view the output *(see example screenshot below)*

![screenshot of the web page](doc/img/screenshot.png?raw=true "a handy screenshot")


## Binaries

If you don't care to compile this yourself, I release the program as binaries for 

* Mac, Linux, and Windows; on 
* x86, amd64, arm, and arm64. 

Just grab them from the [releases link](https://github.com/rossja/webshocket/releases) and go.
