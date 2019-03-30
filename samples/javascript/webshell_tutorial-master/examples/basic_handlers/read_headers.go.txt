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
