## Deploying your app

There are a couple of ways to deploy your app. Each has its own merits and
drawbacks. Let's take a look at a few options:

### Directly

Go can be used directly as a webserver, but this isn't recommended: it would
need to run as root to serve on a privileged port (i.e. 80 / 443), and any
security flaws wouldn't have to go through the extra effort of privilege
escalation. It's better to go through a proxied front end, in my opinion.

### nginx

Setting up an nginx proxy is quite easy. For my own apps, I usually let nginx
handle the TLS connections, and run my apps in http-only mode. Here's a
template:

[`go_service_tls`](/examples/deployment/go_service_tls):

```
upstream goweb {
    server 127.0.0.1:8080;
} 

# force clients to use TLS
server {
    listen 80;
    server_name example.net;
    rewrite ^(.*) https://$host$1 permanent;
}

# proxy to the Go app
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

If you want to serve an HTTP-only app, that's also easy to do.

[`go_service`](/examples/deployment/go_service):

```
upstream goweb {
    server 127.0.0.1:8080;
} 

server {
    listen 80;
    server_name example.net;

    access_log /var/log/nginx/example_access.log;
    error_log /var/log/nginx/example_error.log;
    location / {
        proxy_set_header  X-Real-IP  $remote_addr;
        proxy_pass http://goweb;
    }
}
```

The downside to this option is you need to run your own server. This isn't
too hard to do, and VPSes can be had for quite cheap. I recommend using
[prgmr](http://prgmr.com), [ARP networks](https://www.arpnetworks.com/),
or [linode](http://linode.com). Also, as far as I know, Go doesn't support
daemonisation right now, so you'll need to work around that. For one app,
I just ran it in a [tmux](http://tmux.sourceforge.net/) session.

### Heroku
[Heroku](http://www.heroku.com) can be a good option if you can't run your own
server. The Go buildpack makes deployment pretty simple.
[Keith Rarick](https://github.com/kr) published a
[great quickstart guide](https://gist.github.com/299535bbf56bf3016cba)
as a Github gist.

Heroku will handle all the systems administration side, and you need only focus
on the app. There are a number of addons, you can automatically scale the
number of web front ends and backend workers, they handle database
administration (if you need one), and in general will do a lot of the work for
you. It's also free for a basic app with only one dyno (web or worker instance)
and a 10k-row database.

The downside to Heroku taking care of everything is you don't have control of
most of those things. For most people, that may not be a problem. If Heroku has
an outage, you may not have the infrastructure in place to move your service to
a different machine.

Also, two things that tripped me up on an
[early project](http://twitter.com/lobsternews): dynos are restarted every 24
hours to prevent bit rot, and if you only have one web dyno, it will idle if
it doesn't see a request in the past hour. If your web worker is running any
background processes, these won't run until the next time a request comes in.
If you aren't running any background processes, this won't be an issue - my
project that experienced that did, however, as it relied on an RSS feed fetcher
running in the background.

For most people, this is definitely a viable option. In fact, this app is
currently running on Heroku.
