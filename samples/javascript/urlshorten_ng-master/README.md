# urlshorten
## a urlshortening web service in Go

`urlshorten` is a simple URL shortening service written in Go. It is based
on my [`webshell`](https://gokyle.github.com/webshell) framework, and is a
simple example of writing a web service that includes templating and
authentication.

## Setting Up

The `setup/setup` tool should be used to initialise the database. The database
file defaults to `data/urlshorten.db`. This may be changed in the configuration
file, but the file has to be specified on the command line for the setup tool.

The database should be initialised with `setup -d /path/to/db/file -c` to create
the database. The `-a` flag adds a user to the database, and `-r` removes the
user. The `setup` program will prompt for the user name, and, where applicable,
the password. Note that while the program will create the database file as
needed, it will not create intermediary directories.

Finally, you should create any directories needed to store log files in, and
ensure the service has permission to write them. By default, the service looks
for the directory "logs" in the same directory it was run in.

## The Configuration File

Configuration is done with the [`goconfig`](https://gokyle.github.com/goconfig)
package. The configuration file consists of two sections: `server` and `page`.

### `server`
This section configures the server. It supports the following options:

* `port`: set the port the server should listen on. Defaults to `8080`.
* `host`: set the host the host the server should listen on. This is
separate from the `page` option with this name. Defaults to an empty string
to listen on all interfaces.
* `authenticate`: if set to "false", turns off checks for authentication. This
is on by default.
* `admin_user`: set the administrative user; this is used to add new users to
the site. The default is not set; no users can be added via the site.
* `development`: set this to `false` to disable development features; in
development mode, links are set up as `host:port`. Links in development
mode also use the `http` scheme. If development mode is turned off, links
use `https` and the port is not included in links. Defaults to `true`.
* `dbfile`: specify the path to the database file. Defaults to
`data/urlshorten.db`.
* `access_log`: specify the path to the access log that should be written; if
no file is specified it will default to `logs/access`. The logs are
written to `access-<date>.log`.
* `error_log`: specifiy the path to the error log that should be written;
to the access log.

### `page`
This section controls page templates. Valid options are:

* `title`: sets the page title. Defaults to `urlshorten.go`.
* `host`: the host name to use in links. Defaults to `localhost`. This
affects displayed links to shortcodes only.

### Example production configuration file:

```
[server]
port = 8100
host = 127.0.0.1
development = false
admin_user = flynn

[page]
title = nodality.io
host = nodality.io
```

This will set up a server that listens on `127.0.0.1:8080` in production
mode; pages will have a title of `"nodality.io"` and links will point to
`https://nodality.io`. The user `flynn` can add new users via the web
interface.

## Authentication
If you have enabled authentication, a username and password will be required
to shorten any urls. Enabling authentication also enables the /add and /change
routes. However, you will need to set up an initial user using the command
line tool as noted above.

## Running The Service

It is recommended to run the service behind a proxy; in nginx, you could do
this with

```
upstream goweb {
        server 127.0.0.1:8080;
} 

server {
	listen 80;
	server_name example.net;
	rewrite ^(.*) https://$host$1 permanent;
}

server {
	listen 443 ;
	server_name example.net

	access_log /var/log/nginx/example_access.log;
	error_log /var/log/nginx/example_error.log;
	location / {
  		proxy_set_header  X-Real-IP  $remote_addr;
		proxy_pass http://goweb;
	}

        ssl on;
	ssl_certificate /etc/ssl/certs/example.pem;
	ssl_certificate_key /etc/ssl/private/example.key;

	ssl_session_timeout 5m;

	ssl_protocols TLSv1;
	ssl_ciphers ALL:!ADH:!EXPORT56:RC4+RSA:+HIGH:!MEDIUM:!LOW:+SSLv3:+EXP;
	ssl_prefer_server_ciphers on;

}
```

In this case, nginx handles all the TLS aspects and proxies incoming requests.

Then, navigate to `https://example.net/`. Your passwords may be changed with
`https://example.net/change`. You can add a new user at
`https://example.net/add`. 

