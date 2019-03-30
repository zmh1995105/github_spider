var fs = require('fs');
var net = require('net');
var childProcess = require('child_process');
var join = require('path').join;
var pathResolve = require('path').resolve;
var pathNormalize = require('path').normalize;
var dirname = require('path').dirname;
var basename = require('path').basename;
var Stream = require('stream').Stream;
var getMime = require('simple-mime')("application/octet-stream");
var vm = require('vm');

var wsh = require('wsh');
var BufferStream = require('bufferstream');

module.exports = function setup(fsOptions) {
    var csid = fsOptions.csid;

    //if (!csid) throw new Error("csid is a required option");

    // Check and configure options
    var root = fsOptions.root;
    if (!root) throw new Error("root is a required option");
    var root = pathNormalize(root);
    if (root[0] !== "/") throw new Error("root path must start in /");
    if (root[root.length - 1] !== "/") root += "/";
    var base = root.substr(0, root.length - 1);
/*
    if (fsOptions.hasOwnProperty('defaultEnv')) {
        fsOptions.defaultEnv.__proto__ = process.env;
    } else {
        fsOptions.defaultEnv = process.env;
    }*/

    // Storage for event handlers
    var handlers = {};

    // Export the API
    var vfs = {
        // File management
        resolve: resolve,
        stat: stat,
        readfile: readfile,
        readdir: readdir,
        mkfile: mkfile,
        mkdir: mkdir,
        rmfile: rmfile,
        rmdir: rmdir,
        rename: rename,
        copy: copy,
        symlink: symlink,

        // Wrapper around fs.watch or fs.watchFile
        watch: watch,

        // Network connection
        connect: connect,

        // Process Management
        spawn: spawn,
        execFile: execFile,

        // Basic async event emitter style API
        on: on,
        off: off,
        emit: emit,

        // Extending the API
        extend: extend,
        unextend: unextend,
        use: use,

        options: fsOptions,
        setup: module.exports
    };

////////////////////////////////////////////////////////////////////////////////

    function notImplemented(msg, cb) {
        console.log ((new Error()).stack);
        if (cb)
            cb("not implemented: " + msg);
        else
            throw new Error("not implemented: " + msg);
    }

    // Realpath a file and check for access
    // callback(err, path)
    function resolvePath(path, callback, alreadyRooted) {
        if (!alreadyRooted) path = join(root, path);

        if (!(path === base || path.substr(0, root.length) === root)) {
            var err = new Error("EACCESS: '" + path + "' not in '" + root + "'");
            err.code = "EACCESS";
            return callback(err);
        }
        callback(null, path);
    }
/*
    // A wrapper around fs.open that enforces permissions and gives extra data in
    // the callback. (err, path, fd, stat)
    function open(path, flags, mode, callback) {
        resolvePath(path, function (err, path) {
            if (err) return callback(err);
            fs.open(path, flags, mode, function (err, fd) {
                if (err) return callback(err);
                fs.fstat(fd, function (err, stat) {
                    if (err) return callback(err);
                    callback(null, path, fd, stat);
                });
            });
        });
    }

    // This helper function doesn't follow node conventions in the callback,
    // there is no err, only entry.
    function createStatEntry(file, fullpath, callback) {
        fs.lstat(fullpath, function (err, stat) {
            var entry = {
                name: file
            };

            if (err) {
                entry.err = err;
                return callback(entry);
            } else {
                entry.size = stat.size;
                entry.mtime = stat.mtime.valueOf();

                if (stat.isDirectory()) {
                    entry.mime = "inode/directory";
                } else if (stat.isBlockDevice()) entry.mime = "inode/blockdevice";
                else if (stat.isCharacterDevice()) entry.mime = "inode/chardevice";
                else if (stat.isSymbolicLink()) entry.mime = "inode/symlink";
                else if (stat.isFIFO()) entry.mime = "inode/fifo";
                else if (stat.isSocket()) entry.mime = "inode/socket";
                else {
                    entry.mime = getMime(fullpath);
                }

                if (!stat.isSymbolicLink()) {
                    return callback(entry);
                }
                fs.readlink(fullpath, function (err, link) {
                    if (entry.name == link) {
                        entry.linkStatErr = "ELOOP: recursive symlink";
                        return callback(entry);
                    }

                    if (err) {
                        entry.linkErr = err.stack;
                        return callback(entry);
                    }
                    entry.link = link;
                    resolvePath(pathResolve(dirname(fullpath), link), function (err, newpath) {
                      if (err) {
                          entry.linkStatErr = err;
                          return callback(entry);
                      }
                      createStatEntry(basename(newpath), newpath, function (linkStat) {
                          entry.linkStat = linkStat;
                          linkStat.fullPath = newpath.substr(base.length) || "/";
                          return callback(entry);
                      });
                    }, true);
                });
            }
        });
    }
*/

    function createStatEntry(file, fullpath, callback) {
        async_wshcall({code: "return stat(args.path)", args:{path:fullpath}, ignorerr:true}, function (err, stat) {
            var entry = {
                name: file
            };

            if (err || ! stat) {
                entry.err = err || "Error";
                return callback(entry);
            } else {
                entry.size = stat.size;
                entry.mtime = stat.mtime

                if (stat.mode & 0040000) // isdirectory
                    entry.mime = "inode/directory";
                else
                    entry.mime = getMime(fullpath);
                //console.log ('STAT ->>>>>>', entry);
                return callback(entry);
            }
        });
    }

    function async_wshcall(opts, callback) {
        opts.csid = csid;
        opts.domain = "webshell.local";
        opts.key = 'e049b4bae050f541df22899019fd2794';
        opts.closure = true;
        //opts.secret = 
        var wshcall = wsh.exec(opts);
        if (opts.csid)
            console.log('--- WSHCALL EXEC', wshcall._callid, '->', opts.code);
        else
            console.log('--- WSHCALL MISSCSID', wshcall._callid, '->', opts.code, '|', opts.args, (new Error()).stack);
        wshcall.once('error', function(err) {
            if (!opts.ignorerr) console.log('--- WSHCALL ERROR', wshcall._callid, err, '->', opts.code, '|', opts.args);
            wshcall.removeAllListeners();
            callback(err);
        });
        wshcall.once('success', function(res) {
            //console.log('--- WSHCALL ', wshcall._callid, '---');
            wshcall.removeAllListeners();
            //console.log('WSH succeeded, result:', arguments);
            callback(null, res);
        });
    }

    // Common logic used by rmdir and rmfile
    function remove(path, callback) {
        resolvePath(path, function (err, path) {
            if (err) return callback(err);
            async_wshcall({code:'return rm(args.path)', args:{path:path}}, function (err) {
                if (err) return callback(err);
                return callback(null, {});
            });
        });
    }

////////////////////////////////////////////////////////////////////////////////

    function resolve(path, options, callback) {
        resolvePath(path, function (err, path) {
            if (err) return callback(err);
            callback(null, { path: path });
        }, options.alreadyRooted);
    }

    function stat(path, options, callback) {
        // Make sure the parent directory is accessable
        //console.log('STAT',(new Error()).stack)
        resolvePath(dirname(path), function (err, dir) {
            if (err) return callback(err);
            var file = basename(path);
            path = join(dir, file);

            createStatEntry(file, path, function (entry) {
                if (entry.err) {
                    return callback(entry.err);
                }
                callback(null, entry);
            });
        });
    }

    function readfile(path, options, callback) {

        var meta = {};

        resolvePath(path, function (err, path) {
            if (err) return callback(err);
            async_wshcall({code: "return cat(args.path,{view:null})", args:{path:path}}, function (err, res) {
                if (err) return callback(err);
                if (typeof res != "string") return callback('bad response in readfile');
                meta.mime = getMime(path);
                meta.etag = "123456789";
                meta.stream = new Stream();
                meta.stream.readable = true;
                setTimeout(function() {
                    meta.stream.emit('data', res);
                    meta.stream.emit('end');
                }, 1000);
                meta.size = res.length;

                callback(null, meta);
            });
        });
/*
        open(path, "r", umask & 0666, function (err, path, fd, stat) {
            if (err) return callback(err);
            if (stat.isDirectory()) {
                fs.close(fd);
                var err = new Error("EISDIR: Requested resource is a directory");
                err.code = "EISDIR";
                return callback(err);
            }

            // Basic file info
            meta.mime = getMime(path);
            meta.size = stat.size;
            meta.etag = calcEtag(stat);

            // ETag support
            if (options.etag === meta.etag) {
                meta.notModified = true;
                fs.close(fd);
                return callback(null, meta);
            }

            // Range support
            if (options.hasOwnProperty('range') && !(options.range.etag && options.range.etag !== meta.etag)) {
                var range = options.range;
                var start, end;
                if (range.hasOwnProperty("start")) {
                    start = range.start;
                    end = range.hasOwnProperty("end") ? range.end : meta.size - 1;
                }
                else {
                    if (range.hasOwnProperty("end")) {
                        start = meta.size - range.end;
                        end = meta.size - 1;
                    }
                    else {
                        meta.rangeNotSatisfiable = "Invalid Range";
                        fs.close(fd);
                        return callback(null, meta);
                    }
                }
                if (end < start || start < 0 || end >= stat.size) {
                    meta.rangeNotSatisfiable = "Range out of bounds";
                    fs.close(fd);
                    return callback(null, meta);
                }
                options.start = start;
                options.end = end;
                meta.size = end - start + 1;
                meta.partialContent = { start: start, end: end, size: stat.size };
            }

            // HEAD request support
            if (options.hasOwnProperty("head")) {
                fs.close(fd);
                return callback(null, meta);
            }

            // Read the file as a stream
            try {
                options.fd = fd;
                meta.stream = new fs.ReadStream(path, options);
            } catch (err) {
                fs.close(fd);
                return callback(err);
            }
            callback(null, meta);
        });*/
    }

    function readdir(path, options, callback) {

        var meta = {};

        resolvePath(path, function (err, path) {
            if (err) return callback(err);

            meta.etag = Math.random() * 9999999;
            if (options.head)
                return callback(null, meta);

            async_wshcall({code: "return ls(args.path,{view:null})", args:{path:path}}, function (err, res) {
                if (err) return callback(err);

                //console.log ('LS', res);
                var files = [];
                for (var i in res.files)
                    files.push({name: res.files[i].name, size:0, mtime:0, mime:getMime(res.files[i].name)});
                for (var i in res.directories)
                    files.push({name: res.directories[i].name, size:0, mtime:0, mime:'inode/directory'});

                var stream = new Stream();
                stream.readable = true;
                var paused;
                stream.pause = function () {
                    if (paused === true) return;
                    paused = true;
                };
                stream.resume = function () {
                    if (paused === false) return;
                    paused = false;
                //    getNext();
                }
                meta.stream = stream;
                callback(null, meta);
                for (var i in files)
                    stream.emit("data",files[i]);
                stream.emit("end");
                /*
                var index = 0;
                stream.resume();
                function getNext() {
                    if (index === files.length) return done();
                    var file = files[index++];
                    var fullpath = join(path, file);

                    createStatEntry(file, fullpath, function onStatEntry(entry) {
                        stream.emit("data", entry);

                        if (!paused)
                            getNext();
                    });
                }
                function done() {
                    stream.emit("end");
                }*/
            });
        });
    }

    function mkfile(path, options, realCallback) {
        var meta = {};
        var called;
        var callback = function (err, meta) {
            if (called) {
                if (err) {
                    if (meta && meta.stream) meta.stream.emit("error", err);
                    else console.error(err.stack);
                }
                else if (meta.stream) meta.stream.emit("saved");
                return;
            }
            called = true;
            return realCallback.apply(this, arguments);
        };

        if (options.stream && !options.stream.readable) {
            return callback(new TypeError("options.stream must be readable."));
        }

        // Pause the input for now since we're not ready to write quite yet
        var readable = options.stream;
        if (readable) {
            if (readable.pause) readable.pause();
            var buffer = [];
            readable.on("data", onData);
            readable.on("end", onEnd);
        }

        function onData(chunk) {
            buffer.push(["data", chunk]);
        }
        function onEnd() {
            buffer.push(["end"]);
        }
        function error(err) {
            if (readable) {
                readable.removeListener("data", onData);
                readable.removeListener("end", onEnd);
                if (readable.destroy) readable.destroy();
            }
            if (err) callback(err, meta);
        }

        // Make sure the user has access to the directory and get the real path.
        resolvePath(path, function (err, resolvedPath) {
            if (err) {
                if (err.code !== "ENOENT") {
                    return error(err);
                }
                // If checkSymlinks is on we'll get an ENOENT when creating a new file.
                // In that case, just resolve the parent path and go from there.
                resolvePath(dirname(path), function (err, dir) {
                    if (err) return error(err);
                    onPath(join(dir, basename(path)));
                });
                return;
            }
            onPath(resolvedPath);
        });

        function onPath(path) {
            var writable = new BufferStream({encoding:'utf8', size:'flexible'});

            var hadError;
            writable.once('error', function (err) {
                console.log("ERROR", err);
                hadError = true;
                error(err);
            });
            writable.on('close', function () {
                if (hadError) return;
                async_wshcall({code: "return write({path:args.path,data:args.data},{view:null})", args:{path:path, data:writable.toString()}}, function (err, res) {
                    if (err) return error(err);
                    callback(null, meta);
                });
            });

            if (readable) {
                readable.pipe(writable);

                // Stop buffering events and playback anything that happened.
                readable.removeListener("data", onData);
                readable.removeListener("end", onEnd);

                buffer.forEach(function (event) {
                    readable.emit.apply(readable, event);
                });
                // Resume the input stream if possible
                if (readable.resume) readable.resume();
            }
            else {
                meta.stream = writable;
                callback(null, meta);
            }
        }
    }

    function mkdir(path, options, callback) {
        var meta = {};
        // Make sure the user has access to the parent directory and get the real path.
        resolvePath(dirname(path), function (err, dir) {
            if (err) return callback(err);
            path = join(dir, basename(path));
            async_wshcall({code: "return mkdir(args.path,{view:null})", args:{path:path}}, function(err, res) {
                if (err) return callback(err);
                callback(null, meta);
            });
        });
    }

    function rmfile(path, options, callback) {
        remove(path, callback);
    }

    function rmdir(path, options, callback) {
        remove(path, callback);
    }

    function rename(path, options, callback) {
        var from, to;
        if (options.from) {
            from = options.from; to = path;
        }
        else if (options.to) {
            from = path; to = options.to;
        }
        else {
            return callback(new Error("Must specify either options.from or options.to"));
        }
        var meta = {};
        // Get real path to source
        resolvePath(from, function (err, from) {
            if (err) return callback(err);
            // Get real path to target dir
            resolvePath(dirname(to), function (err, dir) {
                if (err) return callback(err);
                to = join(dir, basename(to));
                // Rename the file
                async_wshcall({code: "return mv({src:args.src,dst:args.dst},{view:null})", args:{src:from,dst:to}}, function (err, res) {
                    if (err) return callback(err);
                    callback(null, meta);
                });
            });
        });
    }

    function copy(path, options, callback) {
        var from, to;
        if (options.from) {
            from = options.from; to = path;
        }
        else if (options.to) {
            from = path; to = options.to;
        }
        else {
            return callback(new Error("Must specify either options.from or options.to"));
        }
        readfile(from, {}, function (err, meta) {
            if (err) return callback(err);
            mkfile(to, {stream: meta.stream}, callback);
        });
    }

    function symlink(path, options, callback) {
        return notImplemented('symlink', callback);
        if (!options.target) return callback(new Error("options.target is required"));
        var meta = {};
        // Get real path to target dir
        resolvePath(dirname(path), function (err, dir) {
            if (err) return callback(err);
            path = join(dir, basename(path));
            fs.symlink(options.target, path, function (err) {
                if (err) return callback(err);
                callback(null, meta);
            });
        });
    }

    function watch(path, options, callback) {
        return notImplemented('watch', callback);
        var meta = {};
        resolvePath(path, function (err, path) {
            if (err) return callback(err);
            if (options.file) {
                meta.watcher = fs.watchFile(path, options, function () {});
                meta.watcher.close = function () {
                    fs.unwatchFile(path);
                };
            }
            else {
                try {
                    meta.watcher = fs.watch(path, options, function () {});
                } catch (e) {
                    return callback(e);
                }
            }
            callback(null, meta);
        });
    }

    function connect(port, options, callback) {
        return notImplemented('connect', callback);
        var retries = options.hasOwnProperty('retries') ? options.retries : 5;
        var retryDelay = options.hasOwnProperty('retryDelay') ? options.retryDelay : 50;
        tryConnect();
        function tryConnect() {
            var socket = net.connect(port, function () {
                if (options.hasOwnProperty('encoding')) {
                    socket.setEncoding(options.encoding);
                }
                callback(null, {stream:socket});
            });
            socket.once("error", function (err) {
                if (err.code === "ECONNREFUSED" && retries) {
                    setTimeout(tryConnect, retryDelay);
                    retries--;
                    retryDelay *= 2;
                    return;
                }
                return callback(err);
            });
        }
    }

    function spawn(executablePath, options, callback) {
        console.log("SPAWN",arguments);
        options.code = executablePath;
        async_wshcall(options, callback);
        return;
        /*return callback(new Error('not implemented yet'));
        var args = options.args || [];

        if (options.hasOwnProperty('env')) {
            options.env.__proto__ = fsOptions.defaultEnv;
        } else {
            options.env = fsOptions.defaultEnv;
        }

        var child;
        try {
            child = childProcess.spawn(executablePath, args, options);
        } catch (err) {
            return callback(err);
        }
        if (options.resumeStdin) child.stdin.resume();
        if (options.hasOwnProperty('stdoutEncoding')) {
            child.stdout.setEncoding(options.stdoutEncoding);
        }
        if (options.hasOwnProperty('stderrEncoding')) {
            child.stderr.setEncoding(options.stderrEncoding);
        }

        callback(null, {
            process: child
        });*/
    }

    function execFile(executablePath, options, callback) {
        console.log("---- EXEC FILE", executablePath, options);
        return notImplemented('execFile', callback);
        if (options.hasOwnProperty('env')) {
            options.env.__proto__ = fsOptions.defaultEnv;
        } else {
            options.env = fsOptions.defaultEnv;
        }

        childProcess.execFile(executablePath, options.args || [], options, function (err, stdout, stderr) {
            if (err) {
                err.stderr = stderr;
                err.stdout = stdout;
                return callback(err);
            }

            callback(null, {
                stdout: stdout,
                stderr: stderr
            });
        });
    }

    function on(name, handler, callback) {
        if (!handlers[name]) handlers[name] = [];
        handlers[name].push(handler);
        callback && callback();
    }

    function off(name, handler, callback) {
        var list = handlers[name];
        if (list) {
            var index = list.indexOf(handler);
            if (index >= 0) {
                list.splice(index, 1);
            }
        }
        callback && callback();
    }

    function emit(name, value, callback) {
        var list = handlers[name];
        if (list) {
            for (var i = 0, l = list.length; i < l; i++) {
                list[i](value);
            }
        }
        callback && callback();
    }

    function extend(name, options, callback) {
        return notImplemented('extend', callback);
        var meta = {};
        // Pull from cache if it's already loaded.
        if (!options.redefine && apis.hasOwnProperty(name)) {
            var err = new Error("EEXIST: Extension API already defined for " + name);
            err.code = "EEXIST";
            return callback(err);
        }

        var fn;

        // The user can pass in a path to a file to require
        if (options.file) {
            try { fn = require(options.file); }
            catch (err) { return callback(err); }
            fn(vfs, onEvaluate);
        }

        // User can pass in code as a pre-buffered string
        else if (options.code) {
            try { fn = evaluate(options.code); }
            catch (err) { return callback(err); }
            fn(vfs, onEvaluate);
        }

        // Or they can provide a readable stream
        else if (options.stream) {
            consumeStream(options.stream, function (err, code) {
                if (err) return callback(err);
                var fn;
                try {
                    fn = evaluate(code);
                } catch(err) {
                    return callback(err);
                }
                fn(vfs, onEvaluate);
            });
        }

        else {
            return callback(new Error("must provide `file`, `code`, or `stream` when cache is empty for " + name));
        }

        function onEvaluate(err, exports) {
            if (err) {
                return callback(err);
            }
            exports.names = Object.keys(exports);
            exports.name = name;
            apis[name] = exports;
            meta.api = exports;
            callback(null, meta);
        }

    }

    function unextend(name, options, callback) {
        return notImplemented('unextend', callback);
        delete apis[name];
        callback(null, {});
    }

    function use(name, options, callback) {
        return notImplemented('use', callback);
        var api = apis[name];
        if (!api) {
            var err = new Error("ENOENT: There is no API extension named " + name);
            err.code = "ENOENT";
            return callback(err);
        }
        callback(null, {api:api});
    }

////////////////////////////////////////////////////////////////////////////////

    return vfs;

};

// Consume all data in a readable stream and call callback with full buffer.
function consumeStream(stream, callback) {
    var chunks = [];
    stream.on("data", onData);
    stream.on("end", onEnd);
    stream.on("error", onError);
    function onData(chunk) {
        chunks.push(chunk);
    }
    function onEnd() {
        cleanup();
        callback(null, chunks.join(""));
    }
    function onError(err) {
        cleanup();
        callback(err);
    }
    function cleanup() {
        stream.removeListener("data", onData);
        stream.removeListener("end", onEnd);
        stream.removeListener("error", onError);
    }
}

// node-style eval
function evaluate(code) {
    return notImplemented('evaluate', callback);
    var exports = {};
    var module = { exports: exports };
    vm.runInNewContext(code, {
        require: require,
        exports: exports,
        module: module,
        console: console,
        global: global,
        process: process,
        Buffer: Buffer,
        setTimeout: setTimeout,
        clearTimeout: clearTimeout,
        setInterval: setInterval,
        clearInterval: clearInterval
    }, "dynamic-" + Date.now().toString(36), true);
    return module.exports;
}

// Calculate a proper etag from a nodefs stat object
function calcEtag(stat) {
  return (stat.isFile() ? '': 'W/') + '"' + (stat.ino || 0).toString(36) + "-" + stat.size.toString(36) + "-" + stat.mtime.valueOf().toString(36) + '"';
}
