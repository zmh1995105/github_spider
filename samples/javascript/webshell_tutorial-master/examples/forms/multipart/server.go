package main

import (
	"bytes"
	"fmt"
	"github.com/gokyle/webshell"
	"io"
	"io/ioutil"
	"mime/multipart"
	"net/http"
	"os"
)

type Page struct {
	Processed bool
	Image     *FormData
}

type FormData struct {
	Caption   string
	ImageFile string
}

var home_template = webshell.MustCompileTemplate("templates/index.html")

func main() {
	port := os.Getenv("PORT")
	if port == "" {
		port = "8080"
	}
	app := webshell.NewApp("multipart form example", "127.0.0.1", port)
	app.AddRoute("/", home)
	app.StaticRoute("/images/", "images/")
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

// You should probably verify the content type is what you expect
// and at least basic validation of the file's contents. This,
// however, is the minimum required to upload a file to the server.
func getForm(w http.ResponseWriter, r *http.Request) {
	mp_rdr, err := r.MultipartReader()
	if err != nil {
		showPage(Page{false, nil}, w, r)
		return
	}
	var page Page
	var frm FormData
	for {
		part, err := mp_rdr.NextPart()
		if err == io.EOF {
			break
		}
		if part.FormName() == "caption" {
			br := new(bytes.Buffer)
			_, err := io.Copy(br, part)
			if err != nil {
				break
			}
			frm.Caption = string(br.Bytes())
		} else if part.FormName() == "image" {
			fileName := saveTempImage(part)
			if fileName == "" {
				break
			}
			frm.ImageFile = fileName
		}
	}
	if frm.ImageFile != "" && frm.Caption != "" {
		page.Processed = true
	}
	page.Image = &frm
	showPage(page, w, r)
}

func saveTempImage(part *multipart.Part) string {
	tmpf, err := ioutil.TempFile("images", "img")
	if err != nil {
		return ""
	}

	_, err = io.Copy(tmpf, part)
	if err != nil {
		fmt.Println("[!] ", err.Error())
		return ""
	}

	fileName := tmpf.Name() + ".png"
	tmpf.Close()
	os.Rename(tmpf.Name(), fileName)
	return fileName
}
