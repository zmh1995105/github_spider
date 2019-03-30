## Handling Forms

There are two types of forms to deal with: urlencoded and multipart.

### urlencoded forms
For forms using the default `application/x-www-form-urlencoded`
mime type, the `ParseForm` method on the [`Request`
object](http://golang.org/pkg/net/http/#Request) should be used.

The `http.Request` value (we'll use the standard name of `r`) has
a `Form` field that is initialised when `ParseForm` is called. This
field is a [`net/url.Values`](http://golang.org/pkg/net/url/#Values)
type. We can retrieve the values, which will all be strings, using
the `Get` accessor:

```
        r.ParseForm()
        username := r.Form.Get("user")
```

Alternatively, the `FormValue` method can be used, which calls
`ParseForm` automatically:

```
        username := r.FormValue("user)
```

### multipart forms 
Parsing multipart forms can be done using one of two methods: using
the `ParseMultipartForm()` method (similar to the `ParseForm()`
method or by using the `MultipartReader` method. As `ParseMultipartForm`
is very similar to `ParseForm`, we'll look at `MultipartReader`
instead.

```
        mp_rdr, err := r.MultipartReader()
```

This method returns a [`mime/multipart
Reader`](http://golang.org/pkg/mime/multipart/#Reader) that can be
stepped through to obtain each part of the message. It is already
set up with the boundaries; all that remains is to read the message.
We get the next part by calling `NextPart` on the Reader value; it
returns an [`io.EOF`](http://golang.org/pkg/io/#pkg-variables) error
when there are no more parts to be read.

```
        for {
                part, err := mp_rdr.NextPart()

                // done reading the form
                if err == io.EOF {
                        break
                }
```

From each part, we can get the name of the form field with `FormName`.

```
        if part.Formname() == "foo" {
                // handle the foo field
        }
```

Reading the body takes a little bit of work, however:

```
                if part.FormName() == "caption" {
                        br := new(bytes.Buffer)
                        _, err := io.Copy(br, part)
                        if err != nil {
                                break
                        }
                        frm.Caption = string(br.Bytes())
                }
```

## Examples
I've written a an example for us to look through; because they
contain several files, I've supplied them as compressed archives.

* urlencoded: [tarball](/examples/forms/urlencoded.tgz),
[zip](/examples/forms/urlencoded.zip)
* multipart: [tarball](/examples/forms/multipart.tgz),
[zip](/examples/forms/multipart.zip)

### urlencoded

[`server.go`](/examples/forms/urlencoded/server.go):

```
package main

import (
	"github.com/gokyle/webshell"
	"net/http"
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
	user := FormData{r.Form.Get("name"), r.Form.Get("email")}
	page := Page{true, &user}
	showPage(page, w, r)
}
```

This expects
[`templates/index.html`](/examples/forms/urlencoded/templates/index.html):

```
<!doctype html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>urlencoded form example</title>
  </head>

  <body>
    <h1>It's A Form!</h1>
{{if .Processed}}
    {{with .User}}
    <p>Hello, {{.Name}}!</p>
    {{end}}
{{else}}
    <form action="/" method="post" name="userdata">
      Name: <input type="text" name="name"><br /> 
      Email: <input type="text" name="email"><br />
      <input type="submit">
    </form>
{{end}}
  </body>
</html>
```

### multipart

This needs the "images" directory created (which is done in the examples
directory); it stores the temporarily uploaded images.

[`server.go`](/examples/forms/multipart/server.go)
```
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
```

The [`templates/index.html`](/examples/forms/multipart/templates/index.html)
template that goes with the server:

```
<!doctype html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>urlencoded form example</title>
  </head>

  <body>
    <h1 style="text-align:center">It's A Form!</h1>
{{if .Processed}}
{{with .Image}}
        <img src={{.ImageFile}} width="600" style="display: block;margin-left: auto;margin-right: auto">
        <p style="text-align:center"><em>{{.Caption}}</em></p>
{{end}}
{{else}}
    <p>Upload an image and caption it. Images should be in PNG format.</p>
    <form action="/" method="post" name="userdata" enctype="multipart/form-data">
      Caption: <input type="text" name="caption"><br /> 
      Image: <input type="file" name="image"><br />
      <input type="submit">
    </form>
{{end}}
  </body>
</html>
```

## A Note

These servers don't do any input validation, which is a primary vector for
attacks on your site. For example, when receiving images, you could use the
[`http.DetectContentType`](http://golang.org/pkg/net/http/#DetectContentType)
function to compare the actual content type with what you're expecting to
received:

```
        acceptable_images := []string{"image/jpeg", "image/png"}
        img_ctype := http.img_ctype(image_data)
        acceptable := false

        for _, image_type := range acceptable images {
                if img_ctype == image_type {
                        acceptable = true
                        break
                }
        }

        if !acceptable {
                // reject the image
        }
        // process the image
```

## Conclusion
Be careful when accepting files, and ensure you validate all input coming in.
These are areas that are often avenues of approach for security breaches.

Okay, that wraps up our look at forms. It would be useful in these demo servers
to show errors when invalid forms are sent. Let's take a look at
[error handling](/errors) in webshell.
