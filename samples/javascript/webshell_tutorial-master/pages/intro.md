## Introduction: A Minimal App

I find the best way to learn new APIs is to start using the code. Let's
start with the most basic webapp:

```
package main

import (
        "github.com/gokyle/webshell"
        "net/http"
)

func main() {
        app := webshell.NewApp("minimal app", "127.0.0.1", "8080")
        app.AddRoute("/", itWorks)
        app.Serve()
}

func itWorks(w http.ResponseWriter, r *http.Request) {
        w.Write([]byte("It worked!"))
}
```

If this code is in [`minimal.go`](/examples/intro/minimal.go.txt), we could do this:

```
$ go run server.go
2012/12/06 18:58:35 [+] route / added
2012/12/06 18:58:35 now listening on  127.0.0.1:8080
```

where it will wait, continuing to run. If you open
[localhost:8080](http://localhost:8080) in your browser, you will quickly find
out if it worked ;). The output shows the route being added and the address the
server is listening on. We can later retrieve the app's host, port, and address
using the `Port()`, `Host()`, and `Address()` methods. We'll see these in
action shortly. Right now, let's look at what this program is doing. I will
focus on the `main` and `itWorks` functions, assuming you have at least a
passing familiarity with [Go](http://golang.org).

### The `itWorks` function: sending your page
Go's route handlers have the signature

```
func handler_name(w http.ResponseWriter, r *http.Request)
```

The ResponseWriter is our connection to the client. You can do a couple
things, and we'll see more later, but the most important thing right now
is the `Write` method. This takes a byte slice and writes it to the client.

If we haven't messed with the headers, `Write` will send a default set of
headers with the status 200:

```
$ curl -v localhost:8080
* About to connect() to localhost port 8080 (#0)
*   Trying ::1...
* Connection refused
*   Trying 127.0.0.1...
* connected
* Connected to localhost (127.0.0.1) port 8080 (#0)
> GET / HTTP/1.1
> User-Agent: curl/7.24.0 (x86_64-apple-darwin12.0) libcurl/7.24.0 OpenSSL/0.9.8r zlib/1.2.5
> Host: localhost:8080
> Accept: */*
> 
< HTTP/1.1 200 OK
< Date: Fri, 07 Dec 2012 03:36:20 GMT
< Transfer-Encoding: chunked
< Content-Type: text/plain; charset=utf-8
< 
* Connection #0 to host localhost left intact
It worked!* Closing connection #0
```

### The `main` function: setup and start the app

The first thing we'll need to do is create the app. The constructor takes
three arguments: the app's name (which we can later use for page titles),
the host to listen on, and the port to listen on.

```
        app := webshell.NewApp("minimal app", "127.0.0.1", "8080")
```

Then, we add a route. For this, let's [head over to the next section](/routes).


