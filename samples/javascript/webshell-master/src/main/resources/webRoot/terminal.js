(function($){

    var template = "<div class=\"card\">" +
                    "  <h5 class=\"card-header\" style='height: 24px; padding: 0px;'>Featured</h5>" +
                    "  <div class=\"card-body terminal-container\" style='padding: 0px;'>" +
                    // "    <div class='terminal-container'></div>\n" +
                    "  </div>" +
                    "</div>";

    Terminal.applyAddon(attach);
    Terminal.applyAddon(fit);
    Terminal.applyAddon(webLinks);
    Terminal.applyAddon(search);
    Terminal.applyAddon(winptyCompat);
    Terminal.applyAddon(fullscreen);
    // Terminal.applyAddon(zmodem);

    var XTerm = function(title, url, parent){
        var term = new Terminal({
            macOptionIsMeta: true,
            cursorBlink: true,
            scrollback: 10,
        });

        var shell = $(template);
        parent.append(shell);
        shell.find('.card-header').html(title);
        term.open(shell.find(".terminal-container")[0]);
        var socket = new WebSocket(url);
        socket.onopen = function(){
            term.writeln('socket connect success!')
            term.attach(socket);
        }
        socket.onerror = function(){
            term.writeln('socket connect error!')
        }
        socket.onclose = function(){
            term.writeln("socket close!");
        }
        this.$shell = shell;
        this.term = term;
        this.socket = socket;
        this.$shell.click(function(){
            term.focus();
        })

    }

    XTerm.prototype.resize = function(width, height){
        this.$shell.width(width);
        this.$shell.height(height);
        var bodyHeight = this.$shell.height() - 25;
        this.$shell.find('.card-body').height(bodyHeight);
        this.term.fit();
    }

    XTerm.prototype.resizable = function(){
        var self = this;
        this.$shell.resizable({stop: function(){
                var bodyHeight = self.$shell.height() - 25;
                console.log(bodyHeight);
                self.$shell.find('.card-body').height(bodyHeight);
                self.term.fit();
                self.term.focus();
            }});
    }

    XTerm.prototype.draggable = function(){
        var self = this;
        this.$shell.draggable({
            cursor: "crosshair",
            opacity: 0.35,
            start: function(){
                self.term.focus();
            }});
    }

    var createTerm = function(title, url, el){
        var xTerm = new XTerm(title, url, el);
        return xTerm;
    }


    $.createTerm = createTerm;

})($);
