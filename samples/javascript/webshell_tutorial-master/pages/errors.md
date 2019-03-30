## Error handling

`webshell` comes with a few utility functions for handling errors. The first set is the `ErrorXXX` series of functions. They have the signature `func(message, content_type string, w http.ResponseWriter, r *http.Request)`. The supported erros are:

```
400			500
401			501
403			502
404			503
405
429
```

One use for these functions is template error handling:

```
out, err := webshell.BuildTemplate(pageTemplate, pageData)
if err != nil {
		webshell.Error500(err.Error(), "text/plain", w, r)
}
w.Write(out)
```

* static error pages

We can also build templated error pages:

```
Template404, err := GenerateTemplateErrorHandler(http.StatusNotFound, "templates/404.html")
if err != nil {
	// assuming this code is in the initialisation section,
	// we don't want to proceed if there's an error.
	panic("failed to set up Template404: " + err.Error())
}
```

The returned function has the signature

```
func(in interface{}, w http.ResponseWriter, r *http.Request)
```

and can be used like any other template page; this function ensures the proper header is sent.

Now you should be well on your way to writing a first app. The next question is [how do we deploy it](/deployment)?





