package main

import (
	"fmt"
	"github.com/gokyle/webshell"
	"net/http"
)

var app *webshell.WebApp

func main() {
	app = webshell.NewApp("minimal app", "127.0.0.1", "8080")
	app.AddRoute("/", itWorks)
	app.Serve()
}

func itWorks(w http.ResponseWriter, r *http.Request) {
	w.Write([]byte("It worked!"))

	route := fmt.Sprintf("\nhandling route for %s%s", app.Address(),
		r.URL.Path)
	w.Write([]byte(route))
}
