## Templating pages

As you are probably well aware, generating HTML by hand is... tedious.
Fortunately, we can use templates to make our life easier.

### Template file syntax

Template directives occur in double braces (ex. `{{ }}`). The `.` character
refers to the current variable. At the top level, this will refer to the
variable being passed in. If the variable is a struct, we can refer to the
fields in the template. For example, if we have a `Page` type declared as

```
type Page struct {
        Title string
        User  string
}
```

we could include this fragment in our template:

```
<h1>{{.Title}}</h1>
<p>Hello, {{.User}}!</p>
```

We can also use an `if`, `else`, and `end` in the template for conditions.
The rules for arguments are kind of complex; in its most simple form, we
can check a boolean variable:

```
type Page struct {
        Title     string
        ShowError bool
        Err       string
```

could be passed to the template:

```
<h1>{{.Title}}</h1>
{{if .ShowError}}
<h3 style="color:red">{{.Err}}
{{end}}
```

We can also range over values:

```
type Page struct {
        Users []User
        Title string
}

type User struct {
        Name  string
        Email string
}
```

in this template:

```
<h1>{{.Title}}</h1>
<p>Users:</p>
<ul>
{{range .Users}}
  <li>{{.Name}}'s email is {{.Email}}</li>
{{end}}
</ul>
```

These are just the basics; the [`html/template`](http://golang.org/pkg/html/template)
documentation has more. It is based on the
[`text/template`](http://golang.org/pkg/text/template) package.
[Jan Newmarch](http://jan.newmarch.name) has a
[great writeup on templates](http://jan.newmarch.name/go/template/chapter-template.html)
that is worth reading for more information.

### Using templates in webshell

Webshell provides several functions for dealing with templates. If you want to
compile a template, there are two options:

* `func CompileTemplate(filename string) (tpl *template.Template, err error)` -
this will compile a template, returning an error if it couldn't be compiled.
* `func MustCompileTemplate(filename string) (tpl *template.Template)` -
`MustCompileTemplate` does safe initialisation of a variable storing a
template. It was designed to be used for global variables, and panics if it
failed. For example, the page layout on this site is a global template:

```
        page_tpl = webshell.MustCompileTemplate("templates/page.html")
```

You can check a template without returning the template itself with
`CompileTemplate`:

* `func CheckTemplate(filename string) (err error)`

This could be useful for validating templates before running the app.

Filling in a template is easy enough; the `BuildTemplate` function will
take a template and a value, and return a byte slice and error.

Let's see how this works.

First, take a look at a slightly simplified version of the template for this
page: [`templates/page.html`](/examples/templating/page.txt).

The relevant code (again, slightly simplified):

```
type Page struct {
        Title string
        Body template.HTML
}

func servePage(w http.ResponseWriter, r *http.Request) {
        md_file := getMdFilename(r.URL.Path[1:])
        title := getPageTitle(md_file)
        out, err := loadMarkdown(md_file)
        if err != nil {
                webshell.Error404("Page not found.", "text/plain", w, r)
                return
        }
        page := Page{title, template.HTML(string(out))}
        body, err := webshell.BuildTemplate(page_tpl, page)
        if err != nil {
                webshell.Error500(err.Error(), "text/plain", w, r)
                return
        }
        w.Write(body)
}
```

(The template.HTML() function is provided in the
[`html/template`](http://golang.org/pkg/html/template/) package, which tells
the template that the output is already in HTML and doesn't need to be escaped.
The page body is HTML output generated from parsing the markdown source for
each page. The type for the `Body` field is `template.HTML` accordingly.)

As you can see, I have created a `Page` struct, stored the result of parsing
the markdown file and the page title in a new value. That value is then passed
to `BuildTemplate`, and the result is written to the client.

In the case of an error, the app uses the webshell built-in errors. We'll
[take a look at those](/errors) later.

If you're curious, webshell comes with a
[basic templating example](https://github.com/gokyle/webshell/tree/master/examples/templates).

Let's move on to [handling forms](/forms).
