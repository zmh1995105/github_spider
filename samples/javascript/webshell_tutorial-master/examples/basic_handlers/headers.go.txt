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
