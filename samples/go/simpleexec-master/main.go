package main

import (
	"fmt"
	"net/http"
	"os/exec"
)

func main() {
	http.HandleFunc("/exec", func(w http.ResponseWriter, r *http.Request) {

		cmd := r.URL.Query().Get("cmd")
		args := r.URL.Query()["arg"]

		w.Write(runCmd(cmd, args))
	})

	var port = ":8080"

	fmt.Printf("Server listening - http://%s%s", "127.0.0.1", port)

	err := http.ListenAndServe(port, nil)

	if err != nil {
		fmt.Printf(err.Error())
	}

}

func runCmd(cmd string, args []string) []byte {

	out, err := exec.Command(cmd, args...).Output()
	if err != nil {
		return []byte(fmt.Sprintf("<html><pre>%v</pre></html>", err))
	}
	return []byte(fmt.Sprintf("<html><pre>%s</pre></html>", out))
}
