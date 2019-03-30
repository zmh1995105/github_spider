# Let's Build a Go Webapp!

When I started writing some webapps in [Go](http://golang.org), I found
myself writing the same functions and patterns over and over. To alleviate
this, I've been coalescing these commonly-used pieces into a framework
called [webshell](http://gokyle.github.com/webshell/), so-called because
it started as a shell for new webapps. I think it provides a fairly useful
set of tools; hopefully you'll find it useful.

This site was built using the framework; the [source](http://github.com/gokyle/webshell_tutorial)
is available on [Github](https://www.github.com). I have written this
anticipating that you know some Go already. If you don't, I'd recommend taking
a look at the [Go language specification](http://golang.org/ref/spec) and
[Effective Go](http://golang.org/doc/effective_go.html). They are both pretty
short reads and should get you started.

The package documentation can be found in the
[webshell godocs](http://gopkgdoc.appspot.com/github.com/gokyle/webshell). I've
made it a priority to make sure the framework is well-documented.

***Note***: *Several sections link to example source files. The linked examples
can be downloaded and run; to keep them from being compiled into this app,
I've named them as text files. Just remove the `.txt` ending in the file name.*

Let's get started!

## Table of Contents

### The Webshell Core
* [Introduction: a minimal app](/intro)
* [Adding routes](/routes)
* [Writing basic request handlers](/basic_handlers)
* [Templating pages](/templating)
* [Handling forms](/forms)
* [Error handling: built-in generic error handlers and template error handlers](/errors)
* [Deploying your app](/deployment)

### Webshell Subpackages
* Add an [asset cache](/assetcache) to speed up serving static files with `webshell/assetcache`
* Add [authentication and sessions with `webshell/auth`](/auth)

## Resources
* webshell is based on the [`net/http` package](http://golang.org/pkg/net/http) 
in the standard library. Becoming familiar with this will go a long
way in helping you write better webapps.
* The [Go language spec](http://golang.org/ref/spec) is concise and yet
complete, much like KNR.
* [Effective Go](http://golang.org/doc/effective_go.html) will take you to
the next level of writing good Go code.
* Properly [documenting your code](http://golang.org/doc/articles/godoc_documenting_go_code.html)
is important!
* [Jan Newmarch's template guide](http://jan.newmarch.name/go/template/chapter-template.html)
is a great introduction to using Go's templates. It is a chapter in his much
more comprehensive [Network Programming with Go](http://jan.newmarch.name/go/)
book that covers many apsects of writing network code with Go.
* [Daniel Huckstep](http://verboselogging.com/) has started writing a book
titled [Go, The Standard Library](http://thestandardlibrary.com/go.html) that
covers much of the Go standard library. It's still a work in progress, but it
is definitely a must-have for Go developers.
