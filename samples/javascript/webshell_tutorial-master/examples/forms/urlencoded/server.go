package main

import (
	"github.com/gokyle/webshell"
	"net/http"
	"os"
)

type Page struct {
	Processed bool
	User      *FormData
}

type FormData struct {
	Name  string
	Email string
}

var home_template = webshell.MustCompileTemplate("templates/index.html")

func main() {
	port := os.Getenv("PORT")
	if port == "" {
		port = "8080"
	}
	app := webshell.NewApp("urlencoded form example", "127.0.0.1", port)
	app.AddRoute("/", home)
	app.Serve()
}

func home(w http.ResponseWriter, r *http.Request) {
	if r.Method == "POST" {
		getForm(w, r)
	} else {
		showForm(w, r)
	}
}

func showPage(page Page, w http.ResponseWriter, r *http.Request) {
	out, err := webshell.BuildTemplate(home_template, page)
	if err != nil {
		webshell.Error500(err.Error(), "text/plain", w, r)
	} else {
		w.Write(out)
	}
}

func showForm(w http.ResponseWriter, r *http.Request) {
	page := Page{false, nil}
	showPage(page, w, r)
}

func getForm(w http.ResponseWriter, r *http.Request) {
	r.ParseForm()
	user := FormData{r.FormValue("name"), r.FormValue("email")}
	page := Page{true, &user}
	showPage(page, w, r)
}
