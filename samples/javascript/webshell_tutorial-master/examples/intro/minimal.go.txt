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
