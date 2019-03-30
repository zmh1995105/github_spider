# -*- coding: utf-8 -*-
"""Simplified webshell demo for websockets.

Authentication, error handling, etc are left as an exercise for the reader :)
"""

import logging
import tornado.escape
import tornado.ioloop
import tornado.options
import tornado.web
import tornado.websocket
import os.path
import uuid
import commands

from tornado.options import define, options

define("port", default=8888, help="run on the given port", type=int)


class Application(tornado.web.Application):
    def __init__(self):
        handlers = [
            (r"/", MainHandler),
            (r"/webshellsocket", WebShellSocketHandler),
        ]
        settings = dict(
            cookie_secret="EEB1C2AB05DDF04D35BADFDF776DD4B0",
            template_path=os.path.join(os.path.dirname(__file__), "templates"),
            static_path=os.path.join(os.path.dirname(__file__), "static"),
            xsrf_cookies=True,
            debug=True,
        )
        super(Application, self).__init__(handlers, **settings)


class MainHandler(tornado.web.RequestHandler):
    def get(self):
        self.render("index.html", messages=WebShellSocketHandler.cache)

class WebShellSocketHandler(tornado.websocket.WebSocketHandler):
    
    waiters = set()
    cache = []
    cache_size = 200

    def get_compression_options(self):
        # Non-None enables compression with default options.
        return {}

    def open(self):
        WebShellSocketHandler.waiters.add(self)

    def on_close(self):
        WebShellSocketHandler.waiters.remove(self)

    @classmethod
    def update_cache(cls, WebShell):
        cls.cache.append(WebShell)
        if len(cls.cache) > cls.cache_size:
            cls.cache = cls.cache[-cls.cache_size:]

    @classmethod
    def send_updates(cls, WebShell):
        logging.info("sending message to %d waiters", len(cls.waiters))
        for waiter in cls.waiters:
            try:
                waiter.write_message(WebShell)
            except:
                logging.error("Error sending message", exc_info=True)

    def on_message(self, message):
        logging.info("got message %r", message)
        parsed = tornado.escape.json_decode(message)
        WebShell = {
            "id": str(uuid.uuid4()),
            "body": self._exec_shell(parsed["body"])[1],
            }
        WebShell["html"] = tornado.escape.to_basestring(
            self.render_string("message.html", message=WebShell))

        WebShellSocketHandler.update_cache(WebShell)
        WebShellSocketHandler.send_updates(WebShell)

    def _exec_shell(self, cmd):
        """
        执行页面传来的命令
        """
        try:
            return commands.getstatusoutput(cmd)
        except Exception, e:
            return 0, str(e.args)


def main():
    tornado.options.parse_command_line()
    app = Application()
    app.listen(options.port)
    tornado.ioloop.IOLoop.current().start()


if __name__ == "__main__":
    main()
