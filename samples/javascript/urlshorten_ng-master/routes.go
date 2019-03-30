package main

import (
	"fmt"
	"github.com/gokyle/webshell"
	"github.com/gokyle/webshell/auth"
	"log"
	"net/http"
	"regexp"
	"strings"
)

var (
	admin_user    string
	page_title    string
	server_host   string
	server_secure bool
	server_dev    = true
	strip_views   = regexp.MustCompile("^/views/(.+)$")
	valid_link    = regexp.MustCompile("^\\w+://")
	valid_sid     = regexp.MustCompile("^[\\w-_]+$")
)

var NotFound webshell.TemplateErrorRoute

type Page struct {
	Title     string
	Count     string
	Views     string
	AllViews  string
	Host      string
	ShortCode string
	Posted    bool
	ShowErr   bool
	ShowMsg   bool
	Scheme    string
	Msg       string
	CheckAuth bool
	File      string
}

func (page *Page) getAllViews() {
	count, err := getAllViews()
	if err != nil {
		page.AllViews = "no views"
	} else {
		switch count {
		case 0:
			page.AllViews = "no views"
		case 1:
			page.AllViews = "one view"
		default:
			page.AllViews = fmt.Sprintf("%d views", count)
		}
	}
}

func (page *Page) getPageCount() {
	count, err := countShortened()
	if err != nil {
		page.Count = "No links"
	} else {
		if count == 0 {
			page.Count = "No links"
		} else {
			var verb string
			if count == 1 {
				page.Count = "link"
			} else {
				page.Count = "links"
			}
			page.Count = fmt.Sprintf("%s %d %s", verb, count,
				page.Count)
		}
	}
	return
}

func NewPage() (page *Page) {
	page = new(Page)
	page.Title = page_title
	page.Host = server_host
	page.CheckAuth = check_auth
	page.File = "templates/index.html"

	if server_secure {
		page.Scheme = "https"
	} else {
		page.Scheme = "http"
	}
	return
}

func home(w http.ResponseWriter, r *http.Request) {
	page := NewPage()
	servePage(page, w, r)
	return
}

func servePage(page *Page, w http.ResponseWriter, r *http.Request) {
	page.getPageCount()
	page.getAllViews()
	out, err := webshell.BuildTemplateFile(page.File, page)
	if err != nil {
		webshell.Error404(err.Error(), "text/plain", w, r)
	} else {
		w.Write(out)
	}
	LogRequest(page, r)
}

func serveErr(page *Page, err error, w http.ResponseWriter, r *http.Request) {
	page.ShowErr = true
	page.Msg = err.Error()
	LogError(page, r)
	servePage(page, w, r)
}

func topRoute(w http.ResponseWriter, r *http.Request) {
	if r.Method == "POST" {
		newShortened(w, r)
		return
	}
	sid := r.URL.Path
	if len(sid) > 1 {
		sid = sid[1:len(sid)]
	}
	url, err := lookupShortCode(sid)
	if err != nil {
		home(w, r)
		return
	} else if url != "" {
		err = updateSidViews(sid)
		if err != nil {
			log.Printf("[+] error updating views: %s\n",
				err.Error())
		}
		LogRequest(nil, r)
		http.Redirect(w, r, url, http.StatusTemporaryRedirect)
		return
	}
	if sid != "/" && sid != "/index.html" {
		page := NewPage()
		page.getPageCount()
		page.getAllViews()
		page.Msg = "404 - page not found"
		page.ShowErr = true
		LogError(page, r)
		NotFound(page, w, r)
	} else {
		home(w, r)
	}
}

func newShortened(w http.ResponseWriter, r *http.Request) {
	page := NewPage()
	err := r.ParseForm()
	if err != nil {
		serveErr(page, err, w, r)
		return
	}

	user := r.Form.Get("user")
	pass := r.Form.Get("pass")
	if check_auth && !auth.Authenticate(user, pass) {
		err = fmt.Errorf("Authenticated failed!")
		serveErr(page, err, w, r)
		return
	}
	sid := r.Form.Get("sid")
	url := r.Form.Get("url")
	if len(url) > 0 && !valid_link.MatchString(url) {
		url = "http://" + url
	}
	if len(url) == 0 {
		err := fmt.Errorf("Invalid URL")
		serveErr(page, err, w, r)
		return
	} else if len(sid) > 0 {
		if surl, err := lookupShortCode(sid); err != nil {
			serveErr(page, err, w, r)
			return
		} else if surl != "" && surl != url {
			err = fmt.Errorf("URL already present.")
			if err != nil {
				serveErr(page, err, w, r)
				return
			}
			sid, db_err := urlToSid(url)
			if db_err == nil {
				page.ShortCode = sid
				page.Posted = true
			} else {
				err = db_err
			}
			serveErr(page, err, w, r)
			return
		} else if err = insertShortened(sid, url); err != nil {
			serveErr(page, err, w, r)
			return
		} else if valid_sid.MatchString(sid) {
			page.ShortCode = sid
			page.Posted = true
		} else {
			err = fmt.Errorf("Invalid short code.")
			serveErr(page, err, w, r)
			return
		}
	} else {
		sid, err := ShortenUrl(ValidateShortenedUrl)
		if err != nil {
			serveErr(page, err, w, r)
			return
		}
		if err = insertShortened(sid, url); err != nil {
			serveErr(page, err, w, r)
			return
		} else {
			page.Posted = true
			page.ShortCode = sid
		}
	}
	servePage(page, w, r)
	return
}

func getViews(w http.ResponseWriter, r *http.Request) {
	sid := strip_views.ReplaceAllString(r.URL.Path, "$1")
	sid = strings.TrimRight(sid, "/")
	page := NewPage()
	page.File = "templates/views.html"
	if !valid_sid.MatchString(sid) {
		NotFound(page, w, r)
		return
	}
	count, err := getSidViews(sid)

	var views string
	if err != nil {
                err = fmt.Errorf("invalid short code")
                page.File = "templates/index.html"
                serveErr(page, err, w, r)
                return
	} else {
		if count == 0 {
			views = "no views"
		} else if count == 1 {
			views = "one view"
		} else {
			views = fmt.Sprintf("%d views", count)
		}
	}
	page.ShortCode = sid
        url, err := lookupShortCode(sid)
        if err != nil {
                serveErr(page, err, w, r)
        } else {
	        page.Views = views
                page.ShowMsg = true
                page.Msg = url
	        servePage(page, w, r)
        }
}

func changePass(w http.ResponseWriter, r *http.Request) {
	page := NewPage()
	page.File = "templates/change.html"
	if r.Method != "POST" {
		servePage(page, w, r)
		return
	}
	err := r.ParseForm()
	if err != nil {
		serveErr(page, err, w, r)
		return
	}
	user := r.Form.Get("user")
	pass := r.Form.Get("pass")
	new_pass := r.Form.Get("newpass")
	confirm := r.Form.Get("confirm")

	if new_pass != confirm {
		err = fmt.Errorf("New passwords do not match.")
		serveErr(page, err, w, r)
		return
	}
	if !check_auth || !auth.Authenticate(user, pass) {
		page.Msg = "Authentication failed."
		page.ShowErr = true
		servePage(page, w, r)
		return
	}

	salt, hash := auth.HashPass(new_pass)
	if len(salt) == 0 || len(hash) == 0 {
		page.Msg = "Invalid password."
		page.ShowErr = true
		servePage(page, w, r)
		return
	}
	err = dbChangePass(user, salt, hash)
	if err != nil {
		serveErr(page, err, w, r)
		return
	}
	page.ShowMsg = true
	page.Msg = "Password changed."
	servePage(page, w, r)
}

func addUser(w http.ResponseWriter, r *http.Request) {
	page := NewPage()
	page.File = "templates/add.html"
	if admin_user == "" {
		err := fmt.Errorf("No administrative user specified.")
		serveErr(page, err, w, r)
		return
	}
	if r.Method != "POST" {
		servePage(page, w, r)
		return
	}
	err := r.ParseForm()
	if err != nil {
		serveErr(page, err, w, r)
		return
	}
	user := r.Form.Get("user")
	pass := r.Form.Get("pass")
	if user != admin_user && !auth.Authenticate(user, pass) {
		err = fmt.Errorf("Authentication failed.")
		serveErr(page, err, w, r)
		return
	}
	new_user := r.Form.Get("newuser")
	new_pass := r.Form.Get("newpass")
	salt, hash := auth.HashPass(new_pass)
	if len(salt) == 0 || len(hash) == 0 {
		page.Msg = "Invalid password."
		page.ShowErr = true
		servePage(page, w, r)
		return
	}
	err = addUserToDb(new_user, salt, hash)
	if err != nil {
		serveErr(page, err, w, r)
	} else {
		page.Msg = "User added."
		page.ShowMsg = true
		servePage(page, w, r)
	}
}

func init_auth() {
	auth.LookupCredentials = getPassHash
}
