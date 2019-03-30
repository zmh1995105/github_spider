import multiprocessing

APP_NAME = "webshell"
bind = "unix:/data/run/webshell.sock"
workers = 1
worker_class = 'gevent'
worker_connections = 1000
timeout = 10

daemon = False

pid = "/data/run/%s.pid" % APP_NAME
chdir = "/root/webshell"

accesslog = "-"
errorlog = "/data/log/%s.log" % APP_NAME
loglevel = "info"

