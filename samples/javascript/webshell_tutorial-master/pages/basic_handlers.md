## Basic Request Handlers

Request handlers are functions that can serve a request to the client. To do
this, they must accept two arguments:

* an [`http.ResponseWriter`](http://golang.org/pkg/net/http/#ResponseWriter);
this is typically assigned to the variable `w` for brevity. This structure
is what the server uses to build and send the HTTP response.
* an [`*http.Request`](http://golang.org/pkg/net/http/#Request); this is
typically assigned to the variable `r`. This represents the request the client
sent to the server.

### Writing A Response
Let's first take a look at the `ResponseWriter`. We already saw that just
writing to a client with `Write` will send default headers. It's very easy
to customise the headers sent, or to write a different status besides `200`.
There is one important thing to keep in mind when writing handlers: *you should
only write the header once*.

As an example, let's write a simple `404` handler. The `net/http` package
provides a number of constants for the HTTP statuses, named http.Status<Status>
-- the `404` constant is `http.StatusNotFound`.

```
func NotFound (w http.ResponseWriter, r *http.Request) {
        w.WriteHeader(http.StatusNotFound)
        w.Write([]byte("Page not found."))
}
```

The `WriteHeader` method writes a header, sending it with the specified status.
As this method writes the headers on the wire, it should be called *after*
setting any headers. Here is a simple test server that demonstrates writing
headers.

[`headers.go`](/examples/basic_handlers/headers.go.txt)

```
package main

import (
        "fmt"
        "github.com/gokyle/webshell"
        "net/http"
        "os"
)

var headers map[string]string

func init() {
        headers = make(map[string]string, 0)
}

func main() {
        if (len(os.Args) % 2) != 1 {
                fmt.Println("[!] invalid headers specified")
                fmt.Println("    please specified header value pairs.")
        } else {
                for i := 1; i < len(os.Args); i += 2 {
                        headers[os.Args[i]] = os.Args[i+1]
                }
        }
        app := webshell.NewApp("minimal app", "127.0.0.1", "8080")
        app.AddRoute("/", headerHandler)
        app.Serve()
}

func headerHandler(w http.ResponseWriter, r *http.Request) {
        for k, v := range headers {
                w.Header().Set(k, v)
        }
        w.WriteHeader(http.StatusOK)
        w.Write([]byte("hello world"))
}
```

Let's fire it up:

```
$ go run headers.go hello world foo bar baz quux
2012/12/06 23:47:02 [+] route / added
2012/12/06 23:47:02 now listening on  127.0.0.1:8080
```

If we make a request with cUrl, we can see the headers being written:

```
$ curl -I localhost:8080
HTTP/1.1 200 OK
Baz: quux
Date: Fri, 07 Dec 2012 06:47:42 GMT
Foo: bar
Hello: world
```

Note that when manually setting headers, `net/http` won't set any default
headers (except for the date header). Therefore, you should be setting
the `content-type`, `transfer-encoding`, and `connection` headers as
appropriate.

### Looking at the request
The `Request` value contains all the information we have about the client's
request. Some quick notes:

* The `Method` field contains the method (in uppercase) - i.e., GET, POST,
etc...
* The `RemoteAddr` field contains the client's IP; however, if the server is
proxied behind another server (i.e. an [nginx](http://nginx.org) proxy,
or for apps running under Heroku), this will be the IP of the proxy.


#### The request URL
One of the most useful things when we're handling requests is to
be able to inspect the request path. The request object includes a
[`net/url`](http://golang.org/pkg/net/url/#URL) object (`r.URL`)
with the client's complete resource request. When routing, we'll
probably be interested in the `Path` field. We saw this being used
in the [`routes.go`](/examples/routes/routes.go.txt) example. The `URL`
also contains the query: we can get the raw query with the `RawQuery`
field, or use the `Query()` method to get at the queries:

[`query.go`](/examples/basic_handlers/query.go.txt):

```
package main

import (
	"fmt"
	"github.com/gokyle/webshell"
	"net/http"
)

func main() {
	app := webshell.NewApp("minimal app", "127.0.0.1", "8080")
	app.AddRoute("/", queryParser)
	app.Serve()
}

func queryParser(w http.ResponseWriter, r *http.Request) {
	w.Write([]byte("It worked!\n"))
	if r.URL.RawQuery == "" {
		return
	}

	queries := r.URL.Query()
	// the net/url.Values type returned by ParseQuery is a
	// map[string][]string
	for k, vlst := range queries {
		w.Write([]byte(fmt.Sprintf("\t%s:", k)))
		for _, v := range vlst {
			w.Write([]byte(fmt.Sprintf(" %s", v)))
		}
		w.Write([]byte("\n"))
	}

}
```

You can pull up the server locally and try some of the following requests:

* http://localhost:8080/
* http://localhost:8080/?foo
* http://localhost:8080/?foo=bar
* http://localhost:8080/?foo=bar;baz=quux
* http://localhost:8080/?foo=bar&foo=baz
* http://localhost:8080/?foo=bar&baz=quux

#### Reading headers
We can also grab headers from the
[`request`](http://golang.org/pkg/net/http/#Request) object:

[`read_headers.go`](/examples/basic_handlers/read_headers.go.txt):

```
package main

import (
	"fmt"
	"github.com/gokyle/webshell"
	"net/http"
	"strings"
)

func main() {
	app := webshell.NewApp("minimal app", "127.0.0.1", "8080")
	app.AddRoute("/", read_headers)
	app.Serve()
}

func read_headers(w http.ResponseWriter, r *http.Request) {
	response := fmt.Sprintf("The client sent the headers:\n")
	for k, values := range r.Header {
		response += fmt.Sprintf("\t%s: ", k)
		values = strings.Split(values[0], ";")
		for _, value := range values {
			response += fmt.Sprintf("%s, ", value)
		}
		response += fmt.Sprintf("\n")
	}
	w.Write([]byte(response))
}
```

In [`net/http`](http://golang.org/pkg/net/http), the header is defined as a
`map[string][]string`.

There's more to the request object than what we've seen here; for more
information you can check out the
[`Request` documentation](http://golang.org/pkg/net/http/#Request).

Let's take a look at [using templates now](/templating).
