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
