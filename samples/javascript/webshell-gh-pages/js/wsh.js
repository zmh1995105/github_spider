;(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);throw new Error("Cannot find module '"+o+"'")}var f=n[o]={exports:{}};t[o][0].call(f.exports,function(e){var n=t[o][1][e];return s(n?n:e)},f,f.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
// CLI parsed-command executor
// ===========================

// Executor
// ========
var Executor = {};
module.exports = Executor;

Executor.exec = function(parsed_cmds) {
	var emitter = new local.util.EventEmitter();
	emitter.next_index = 0;
	emitter.parsed_cmds = parsed_cmds;
	emitter.getNext = getNext;
	emitter.start = emitter.fireNext = fireNext;
	emitter.on('request', onRequest);
	emitter.on('dispatch', onDispatch);
	emitter.on('response', onResponse);
	return emitter;
};

function getNext() {
	return this.parsed_cmds[this.next_index];
}

function fireNext() {
	if (this.getNext()) {
		this.emit('request', this.getNext());
		this.emit('dispatch', this.getNext());
		this.next_index++;
	} else {
		this.emit('done');
	}
}

function onRequest(cmd) {
	// Prep request
	var body = cmd.request.body;
	var req = new local.Request(cmd.request);

	// pull accept from right-side pipe
	if (cmd.pipe && !cmd.request.accept) { req.header('Accept', pipeToType(cmd.pipe)); }

	// pull body and content-type from the last request
	if (cmd.last_res) {
		if (cmd.last_res.header('Content-Type') && !req.header('Content-Type')) {
			req.header('Content-Type', cmd.last_res.header('Content-Type'));
		}
		if (cmd.last_res.body) {
			body = cmd.last_res.body;
		}
	}

	// act as a data URI if no URI was given (but a body was)
	if (!req.url && body) {
		var type = (cmd.pipe) ? pipeToType(cmd.pipe) : 'text/plain';
		req.url = 'data:'+type+','+body;
		req.method = 'GET';
	}
	// default method
	else if (!cmd.request.method) {
		if (typeof body != 'undefined') req.method = 'POST';
		else req.method = 'GET';
	}

	// Update command
	cmd.request = req;
	cmd.body = body;
}

function onDispatch(cmd) {
	var emitter = this;

	// Dispatch
	local.dispatch(cmd.request).always(function(res) {
		//var will_be_done = !emitter.getNext();
		emitter.emit('response', { request: cmd.request, response: res });
		/*if (will_be_done) {
			emitter.emit('done');
		}*/
	});
	cmd.request.end(cmd.body);
}

function onResponse(e) {
	var next_cmd = this.getNext();
	if (next_cmd) {
		next_cmd.last_res = cmd.response;
	}
	local.util.nextTick(this.fireNext.bind(this));
}

var pipeMap = {
	html: 'text/html',
	text: 'text/plain',
	plain: 'text/plain',
	json: 'application/json'
};
function pipeToType(v) {
	return pipeMap[v] || v;
}
},{}],2:[function(require,module,exports){
var _updates = [];
var _cursor = -1;

function add(from, cmd, response) {
	var update = { id: _updates.length, from: from, cmd: cmd, response: response, created_at: Date.now() };
	_updates.push(update);
	_cursor = update.id + 1;
	return update;
}

function get(id) {
	return _updates[id];
}

function getAll(id) {
	return _updates;
}

function set(id, from, cmd, response) {
	if (!from && !cmd && !response)
		_updates[id] = null;
	else {
		_updates[id].from = from;
		_updates[id].cmd = cmd;
		_updates[id].response = response;
	}
}

function setCursor(cursor) {
	_cursor = cursor;
}

function moveCursor(delta) {
	var new_pos = _cursor + delta;
	if (new_pos >= 0 && new_pos < _updates.length) {
		_cursor = new_pos;
	}
	return (_updates[_cursor]) ? _updates[_cursor].cmd : '';
}


module.exports = {
	add: add,
	get: get,
	getAll: getAll,
	set: set,

	setCursor: setCursor,
	moveCursor: moveCursor
};
},{}],3:[function(require,module,exports){
// Command Line Interface
// ======================
var util = require('../util');
var cliParser = require('./parser');
var cliExecutor = require('./executor');
var cliHistory = require('./history');

var server = servware();
module.exports = server;

$('#cmd-in').on('keyup', function(e) {
	var is_up = (e.keyCode == 38);
	var is_down = (e.keyCode == 40);
	if (is_up || is_down) {
		// History scrolling with up/down
		$(this).val(cliHistory.moveCursor((is_up) ? (-1) : (+1)));
	}

	var is_enter = (e.keyCode == 13);
	if (is_enter) {
		// Clear input on enter
		$(this).val('');
	}
});

function execute(req, res) {
	// Validate inputs
	var cmd, cmdParsed, update;
	req.assert({ type: ['application/json', 'application/x-www-form-urlencoded', 'text/plain'] });
	if (typeof req.body == 'string') { cmd = req.body; }
	else if (req.body.cmd) { cmd = req.body.cmd; }
	else { throw [422, 'Must pass a text/plain string or an object with a `cmd` string attribute.']; }

	// Parse
	try {
		cmdParsed = cliParser.parse(cmd);
	} catch (e) {
		// Parsing error
		return [400, e.toString(), {'Content-Type': 'text/plain'}];
	}

	// Execute
	var res_ = local.promise();
	var cmdTask = cliExecutor.exec(cmdParsed);
	var lastReq, lastRes;
	cmdTask.on('request', function(cmd) {
		// Set request headers
		cmd.request.header('From', 'httpl://cli');
	});
	cmdTask.on('response', function(cmd) { lastReq = cmd.request; lastRes = cmd.response; });
	cmdTask.on('done', function() {
		// Add to history
		// :TODO: needed?
		var urld = local.parseUri(lastReq);
		var origin = (urld.protocol != 'data') ? (urld.protocol || 'httpl')+'://'+urld.authority : null;
		// cliHistory.add(origin, cmd, lastRes); :NOTE: now done in pagent

		// Fulfill response
		lastRes.headers['CLI-Cmd'] = cmd;
		lastRes.headers['CLI-Origin'] = origin;
		res_.fulfill(lastRes);
	});
	cmdTask.start();

	return res_;
}

server.route('/', function(link, method) {
	link({ href: 'httpl://hosts', rel: 'via', id: 'hosts', title: 'Page' });
	link({ href: '/', rel: 'self service collection', id: 'cli', title: 'Command Line' });
	link({ href: '/{id}', rel: 'item', title: 'Update', hidden: true });

	method('HEAD', forbidOthers, function() { return 204; });

	method('POST', forbidOthers, function(req, res) {
		return execute(req, res);
	});
});

server.route('/:id', function(link, method) {
	link({ href: 'httpl://hosts', rel: 'via', id: 'hosts', title: 'Page' });
	link({ href: '/', rel: 'up service collection', id: 'cli', title: 'Command Line' });
	link({ href: '/:id', rel: 'self item', id: ':id', title: 'Update :id' });

	method('HEAD', forbidOthers, function() { return 204; });

	method('GET', forbidOthers, function(req, res) {
		var from = req.header('From');

		var update = cliHistory.get(req.params.id);
		if (!update) throw 404;

		if (from && update.from !== from && from != 'httpl://cli')
			throw 403;

		var accept = local.preferredType(req, ['text/html', 'application/json']);
		/*if (accept == 'text/html') :TODO:
			return [200, html, {'content-type': 'text/html'}];*/
		if (accept == 'application/json')
			return [200, update, {'content-type': 'application/json'}];
		throw 406;
	});

	method('DELETE', forbidOthers, function(req, res) {
		var from = req.header('From');

		var update = cliHistory.get(req.params.id);
		if (!update) throw 404;

		if (from && from != 'httpl://cli')
			throw 403;

		cliHistory.set(update.id, null);

		$('#cli-update-'+req.params.id).remove();

		return 204;
	});
});

function forbidOthers(req, res) {
	var from = req.header('From');
	if (from && from !== 'httpl://'+req.header('Host'))
		throw 403;
	return true;
}
},{"../util":8,"./executor":1,"./history":2,"./parser":4}],4:[function(require,module,exports){
// CLI command parser
// ==================
/*
Examples:
  - A single, full GET command:
	agent> GET apps/foo -From=pfraze@grimwire.net [application/json]
  - A single command using defaults (method=GET, Accept=*, agent=none):
	apps/foo
  - A single POST command with a body
    POST apps/foo --{"foo": "bar"} [json]
  - A fat pipe command:
	GET apps/foo [application/json] POST apps/bar
  - A fat pipe command with defaults:
    apps/foo [] apps/bar

command      = [ agent ] request [ content-type ] .
agent        = token '>' .
request      = [ method ] uri { header-flag } [ body ] .
method       = token .
uri          = ns-token .
header-flag  = '-' header-key '=' header-value .
header-key   = token .
header-value = token | string .
body         = '--' [ string | { ns-token } ] [ '[' | EOF ] .
content-type = '[' token ']' .
string       = '"' { token } '"' .
token        = /(\w[-\w]*)/ .
ns-token     = /(\S*)/ .
*/

// Parser
// ======
var Parser = { buffer: null, trash: null, buffer_position: 0, buffer_size: 0, logging: false };
module.exports = Parser;

// Main API
// - Generates an array of { agent:, request:, pipe: } objects
//  - `agent` is the string name of the agent used
//  - `request` is an object-literal request form
//  - `pipe` is the string mimetype in the fat pipe
Parser.parse = function(buffer) {
	Parser.buffer = buffer;
	Parser.trash = '';
	Parser.buffer_position = 0;
	this.buffer_size = buffer.length;

	var output = [];
	while (!this.isFinished()) {
		output.push(Parser.readCommand());
	}

	return output;
};

Parser.moveBuffer = function(dist) {
	this.trash += this.buffer.substring(0, dist);
	this.buffer = this.buffer.substring(dist);
	this.buffer_position += dist;
	this.log('+', dist);
};

Parser.isFinished = function() {
	if (this.buffer_position >= this.buffer_size || !/\S/.test(this.buffer))
		return true;
	return false;
};

Parser.readCommand = function() {
	// command = [ agent ] request [ request ] .
	// ================================================
	this.log = ((this.logging) ? (function() { console.log.apply(console,arguments); }) : (function() {}));
	this.log('>> Parsing:',this.buffer);

	var agent = this.readAgent();

	var request = this.readRequest();
	if (!request) { throw this.errorMsg("Command expected"); }

	var pipe = this.readContentType();

	this.log('<< Finished parsing:', agent, request);
	return { agent: agent, request: request, pipe: pipe };
};

Parser.readAgent = function() {
	// agent = token '>' .
	// ===================
	// read non spaces...
	var match = /^\s*(\S*)/.exec(this.buffer);
	if (match && />/.test(match[1])) { // check for the identifying angle bracket
		var match_parts = match[1].split('>');
		var agent = match_parts[0];
		this.moveBuffer(agent.length+1);
		this.log('Read agent:', agent);
		return agent;
	}
	return false;
};

Parser.readRequest = function() {
	// request = [ [ method ] uri ] { header-flag } [ body ] .
	// =======================================================
	var targetUri = false, method = false, headers = {}, body, start_pos;
	start_pos = this.buffer_position;
	// Read till no more request features
	while (true) {
		var headerSwitch = this.readHeaderSwitch();
		if (headerSwitch) {
			headers[headerSwitch.key.toLowerCase()] = headerSwitch.value;
			continue;
		}
		body = this.readBody();
		if (body) {
			// body ends the command segment
			break;
		}
		var nstoken = this.readNSToken();
		if (nstoken) {
			// no uri, assume that's what it is
			if (!targetUri) { targetUri = nstoken; }
			else if (!method) {
				// no method, the first item was actually the method and this is the uri
				method = targetUri;
				targetUri = nstoken;
			} else {
				throw this.errorMsg("Unexpected token '" + nstoken + "'");
			}
			continue;
		}
		break;
	}
	// Return a request if we got a URI or body; otherwise, no match
	if (!targetUri && !body) { return false; }
	var request = { headers: headers };
	request.method = method;
	request.url = targetUri;
	if (body) { request.body = body; }
	this.log(request);
	return request;
};

Parser.readContentType = function() {
	// content-type = "[" [ token | string ] "]" .
	// ===========================================
	var match;

	// match opening bracket
	match = /^\s*\[\s*/.exec(this.buffer);
	if (!match) { return false; }
	this.moveBuffer(match[0].length);

	// read content-type
	match = /^[\w\/\*.0-9\+]+/.exec(this.buffer);
	var contentType = (!!match) ? match[0] : null;
	if (contentType)  { this.moveBuffer(contentType.length); }

	// match closing bracket
	match = /^\s*\]\s*/.exec(this.buffer);
	if (!match) { throw this.errorMsg("Closing bracket ']' expected after content-type"); }
	this.moveBuffer(match[0].length);

	this.log('Read mimetype:', contentType);
	return contentType;
};

Parser.readHeaderSwitch = function() {
	// header-flag = "-" header-key "=" header-value .
	// ===============================================
	var match, headerKey, headerValue;

	// match switch
	match = /^(\s*-)[^-]/.exec(this.buffer);
	if (!match) { return false; }
	this.moveBuffer(match[1].length);

	// match key
	headerKey = this.readToken();
	if (!headerKey) { throw this.errorMsg("Header name expected after '-' switch."); }

	// match '='
	match = /^\s*\=/.exec(this.buffer);
	if (match) {
		// match value
		this.moveBuffer(match[0].length);
		if (/^\s/.test(this.buffer)) { throw this.errorMsg("Value expected for -" + headerKey); }
		headerValue = this.readString() || this.readNSToken();
		if (!headerValue) { throw this.errorMsg("Value expected for -" + headerKey); }
	} else {
		// default value to `true`
		headerValue = true;
	}

	var header = { key:headerKey, value:headerValue };
	this.log('Read header:', header);
	return header;
};

Parser.readBody = function() {
	// body = '--' [ string | { ns-token } ] [ '[' | EOF ] .
	// =====================================================
	var match, body;

	// match switch
	match = /^\s*--/.exec(this.buffer);
	if (!match) { return false; }
	this.moveBuffer(match[0].length);

	// match string
	body = this.readString();
	if (!body) {
		// not a string, read till '[' or EOF
		match = /([^\[]*)/.exec(this.buffer);
		if (!match) { body = ''; }
		body = match[1].trim();
		this.moveBuffer(match[0].length);
	}

	this.log('Read body:', body);
	return body;
};

Parser.readString = function() {
	var match;

	// match opening quote
	match = /^\s*[\"\']/.exec(this.buffer);
	if (!match) { return false; }
	this.moveBuffer(match[0].length);
	var quote_char = match[0];

	// read the string till the next un-escaped quote
	var string = '', last_char;
	while (this.buffer.charAt(0) != quote_char || (this.buffer.charAt(0) == quote_char && last_char == '\\')) {
		var c = this.buffer.charAt(0);
		this.moveBuffer(1);
		if (!c) { throw this.errorMsg("String must be terminated by a second quote"); }
		string += c;
		last_char = c;
	}
	this.moveBuffer(1);

	// backlash escape codes
	string = replaceEscapeCodes(string);

	this.log('Read string:', string);
	return string;
};

Parser.readNSToken = function() {
	// read pretty much anything
	var match = /^\s*(\S*)/.exec(this.buffer);
	if (match && match[1].charAt(0) != '[') { // dont match a pipe
		this.moveBuffer(match[0].length);
		this.log('Read uri:', match[1]);
		return match[1];
	}

	return false;
};

Parser.readToken = function() {
	// read the token
	var match = /^\s*(\w[-\w]*)/.exec(this.buffer);
	if (!match) { return false; }
	this.moveBuffer(match[0].length);
	this.log('Read token:', match[1]);
	return match[1];
};

Parser.errorMsg = function(msg) {
	return msg+'\n'+this.trash.slice(-15)+'<span class=text-danger>&bull;</span>'+this.buffer.slice(0,15);
};

var bslash_regex = /(\\)(.)/g;
var escape_codes = { b: '\b', t: '\t', n: '\n', v: '\v', f: '\f', r: '\r', ' ': ' ', '"': '"', "'": "'", '\\': '\\' };
function replaceEscapeCodes(str) {
	return str.replace(bslash_regex, function(match, a, b) {
		var code = escape_codes[b];
		if (!code) throw "Invalid character sequence: '\\"+b+"'";
		return code;
	});
}
},{}],5:[function(require,module,exports){
/**
 * httpl://help
 * Page host providing online help
 */

var util = require('./util.js'); // require using browserify

var server = servware();
module.exports = server;

server.route('/', function(link, method) {
	method('GET', function (req, res) {
		req.assert({ accept: 'text/html' });
		return [200, [
		'<html>',
			'<body>',
				'<p>These buttons are commands which can be clicked or typed into the input at the top of the screen:</p>',
				'<p class="text-muted"><a class="cmd-example" href="httpl://hosts">hosts</a> list active hosts</p>',
				'<p class="text-muted"><a class="cmd-example" href="httpl://help">help</a> this screen</p>',
				'<p class="text-muted"><a class="cmd-example" href="httpl://help/intro">help/intro</a> learn how to use WebShell</p>',
				// '<p><a href="https://github.com/pfraze/webshell" target="_blank">Fork or clone WebShell</a> and host with <a href="http://pages.github.com/" target="_blank">GitHub Pages</a>. You can execute setup requests in ./src/main.js. Use <code>make setup</code> to build.</p>',
			'</body>',
		'</html>'
		].join(''), {'Content-Type': 'text/html'}];
	});
});

function intro1(req, res) {
	req.assert({ accept: 'text/html' });
	return [200, [
		'<p><strong>Welcome to WebShell</strong>. Everything here is powered by Web requests, and the responses are shown in a continuous history.</p>',
		'<p>Fetch the next section:</p>',
		'<p class="text-muted"><a class="cmd-example" href="httpl://help/intro/2">help/intro/2</a> see the next section</p>'
	].join(''), {'Content-Type':'text/html'}];
}

server.route('/intro', function (link, method) {
	method('GET', intro1);
});
server.route('/intro/1', function (link, method) {
	method('GET', intro1);
});

server.route('/intro/2', function (link, method) {
	method('GET', function (req, res) {
		req.assert({ accept: 'text/html' });
		return [200, [
			'<p><strong>Well done!</strong> That was a link you clicked, but the response was added to this history list instead of replacing the page.</p>',
			'<p>You can type commands at the top to generate Web requests, just like links do. Try typing the next command in the input on the top:</p>',
			'<p class="text-muted"><a class="cmd-example">help/intro/3</a> you\'ll have to type this one!</p>'
		].join(''), {'Content-Type':'text/html'}];
	});
});

server.route('/intro/3', function (link, method) {
	method('GET', function (req, res) {
		req.assert({ accept: 'text/html' });
		return [200, [
			'<p><strong>Alright!</strong> Typing commands isn\'t necessary for WebShell, but it does give you a lot of power.</p>',
			'<p>As it so happens, what you just typed is a URL. If you type it out fully, it looks like this:</p>',
			'<p class="text-muted"><a class="cmd-example" href="httpl://help/intro/4">httpl://help/intro/4</a> see the next section</p>'
		].join(''), {'Content-Type':'text/html'}];
	});
});

server.route('/intro/4', function (link, method) {
	method('GET', function (req, res) {
		req.assert({ accept: 'text/html' });
		return [200, [
			'<p><strong>That\'s it</strong>. Luckily, you don\'t have to type the <code>httpl://</code> part - that\'s the default protocol.</p>',
			'<p>When you enter a command, you send a Web request. In this case, it\'s a GET request, which is another default. If included, the command becomes:</p>',
			'<p class="text-muted"><a class="cmd-example" href="httpl://help/intro/5">GET help/intro/5</a> see the next section</p>'
		].join(''), {'Content-Type':'text/html'}];
	});
});

server.route('/intro/5', function (link, method) {
	method('GET', function (req, res) {
		req.assert({ accept: 'text/html' });
		return [200, [
			'<p><strong>Okay.</strong> Web requests all have "methods". A lot of services only use GET and POST, but there are many others.</p>',
			'<p>The next section only supports <code>AWESOME-GET</code>:</p>',
			'<p class="text-muted"><a class="cmd-example" method="AWESOME-GET" href="httpl://help/intro/6">AWESOME-GET help/intro/6</a> awesome-see the next section</p>'
		].join(''), {'Content-Type':'text/html'}];
	});
});

server.route('/intro/6', function (link, method) {
	method('AWESOME-GET', function (req, res) {
		req.assert({ accept: 'text/html' });
		return [200, [
			'<style>',
			'h3 { margin-top: 0 }',
			'.rainbow {',
				'background-image: -webkit-gradient( linear, left top, right top, color-stop(0, #f22), color-stop(0.15, #f2f), color-stop(0.3, #22f), color-stop(0.45, #2ff), color-stop(0.6, #2f2),color-stop(0.75, #2f2), color-stop(0.9, #ff2), color-stop(1, #f22) );',
				'background-image: gradient( linear, left top, right top, color-stop(0, #f22), color-stop(0.15, #f2f), color-stop(0.3, #22f), color-stop(0.45, #2ff), color-stop(0.6, #2f2),color-stop(0.75, #2f2), color-stop(0.9, #ff2), color-stop(1, #f22) );',
				'color: rgba(0,0,0,0.33);',
				'-webkit-background-clip: text;',
				'background-clip: text;',
			'}</style>',
			'<h3><span class="rainbow">AWESOME!!!</span></h3>',
			'<p>You must be wondering what "httpl" is. That\'s a protocol that targets Javascript functions in the page. It is the basis of WebShell\'s power!</p>',
			'<p class="text-muted"><a class="cmd-example" href="httpl://host.com/src/help.js">host.com/src/help.js</a> view the server script behind this interface</p>',
			'<p class="text-muted"><a class="cmd-example" href="httpl://help/intro/7">help/intro/7</a> see the next section</p>'
		].join(''), {'Content-Type':'text/html'}];
	});
});

server.route('/intro/7', function (link, method) {
	method('GET', function (req, res) {
		req.assert({ accept: 'text/html' });
		return [200, [
			'<p><strong>Time to get dangerous!</strong> In WebShell, you can send httpl requests to Web Workers - extra threads that live in the browser. Their addresses look like this:<br><code>httpl://host.com[path/to/worker.js]/</code></p>',
			'<p>This odd URL includes enough information to download the Worker script to handle the request. Once it finishes, the Worker is destroyed.</p>',
			'<p>Let\'s use one to solve a problem we have.</p>',
			'<p class="text-muted"><a class="cmd-example" href="httpl://help/intro/8">help/intro/8</a> (try to) see the next section</p>',
			'<p>Oh no! The next section is only in Markdown, and we need HTML. Thankfully, I run the <code>gwr.io</code> domain, and I left a worker script there for just such an occasion:</p>',
			'<p class="text-muted"><a class="cmd-example" href="httpl://gwr.io[marked.js]?url=help/intro/8">gwr.io[marked.js]?url=help/intro/8</a> (actually!) see the next section</p>'
		].join(''), {'Content-Type':'text/html'}];
	});
});

server.route('/intro/8', function (link, method) {
	method('GET', function (req, res) {
		req.assert({ accept: 'text/plain' });
		return [200, [
			'**That\'s more like it!** That worker script fetched this Markdown from httpl://help, converted it, responded and closed. ([View the Source](http://gwr.io/marked.js))',
			'When the Marked.js Worker was run, it lived in another browser thread and could only talk to this WebShell page. Anything it does must be pre-approved. That makes it safe!',
			'<span class="text-muted"><a class="cmd-example" href="httpl://help/intro/9">help/intro/9</a> see the next section</span>'
		].join('\n\n'), {'Content-Type':'text/plain'}];
	});
});


/*

  <ul class="list-inline">
            <li><a href="https://grimwire.com/local" target="_blank"><img src="img/httplocal_20x20.png"><strong style="color:#333">HTTP<span class="text-danger">Local</span></strong><a></li>
            <li><a href="https://github.com/pfraze/servware" target="_blank"><img src="img/servware_20x20.png"><strong class="text-success">Servware</strong></a></li>
            <li><a href="http://getbootstrap.com/" target="_blank"><img src="img/bootstrap_20x20.png"><strong class="bootstrap-color">Bootstrap 3</strong></a></li>
          </ul>
          */
},{"./util.js":8}],6:[function(require,module,exports){
// Environment Setup
// =================
var pagent = require('./pagent.js');
local.logAllExceptions = true;

// Traffic logging
local.setDispatchWrapper(function(req, res, dispatch) {
	var res_ = dispatch(req, res);
	res_.then(
		function() { console.log(req, res); },
		function() { console.error(req, res); }
	);
});

// Request events
try { local.bindRequestEvents(document.body); }
catch (e) { console.error('Failed to bind body request events.', e); }
document.body.addEventListener('request', function(e) {
	var req = e.detail;
	pagent.dispatchRequest(req, e.target);
});

// Worker management
local.setHostLookup(require('./worker-loader.js').lookupWorker);
local.addServer('worker-bridge', require('./worker-bridge.js'));

// Servers
local.addServer('cli', require('./cli'));
local.addServer('help', require('./help.js'));

pagent.dispatchRequest({ url: 'httpl://help' });


// Server Definiton: httpl://host.com
// ==================================
// - aliases the host path to the local namespace, making it available to workers
(function() {
	var host = window.location.toString();
	host = host.slice(0, host.lastIndexOf('/'));
	var queryparams = local.contentTypes.deserialize('application/x-www-form-urlencoded', location.search.slice(1));
	var cap = (queryparams) ? queryparams.cap : false;
	local.addServer('host.com', function(req, res) {
		var req2 = new local.Request({
			method: req.method,
			url: host+req.path,
			query: local.util.deepClone(req.query),
			headers: local.util.deepClone(req.headers),
			stream: true
		});
		if (cap) { req2.query.cap = cap; }
		local.dispatch(req2).always(function(res2) {
			res.writeHead(res2.status, res2.reason, res2.headers);
			res2.on('data', function(data) { res.write(data); });
			res2.on('end', function() { res.end(); });
			return res2;
		});
		req.on('data', function(chunk) { req2.write(chunk); });
		req.on('end', function() { req2.end(); });
	});
})();
},{"./cli":3,"./help.js":5,"./pagent.js":7,"./worker-bridge.js":9,"./worker-loader.js":10}],7:[function(require,module,exports){
// Page Agent (PAgent)
// ===================
var util = require('./util.js');
var cliHistory = require('./cli/history');

function renderResponse(res) {
	if (res.body !== '') {
		if (typeof res.body == 'string') {
			if (res.header('Content-Type').indexOf('text/html') !== -1)
				return res.body;
			if (res.header('Content-Type').indexOf('javascript') !== -1)
				return '<link href="css/prism.css" rel="stylesheet"><pre><code class="language-javascript">'+util.makeSafe(res.body)+'</code></pre>';
			return '<pre>'+util.makeSafe(res.body)+'</pre>';
		} else {
			return '<link href="css/prism.css" rel="stylesheet"><pre><code class="language-javascript">'+util.makeSafe(JSON.stringify(res.body))+'</code></pre>';
		}
	}
	return res.status + ' ' + res.reason;
}

var iframeCounter = 0;
function createIframe(origin, cmd) {
	var time = (new Date()).toLocaleTimeString();
	var html = [
		'<table class="cli-update" id="cli-update-'+iframeCounter+'">',
			'<tr>',
				'<td>',
					'<p><small class="text-muted">'+time+'</small></p>',
					// (origin?('<p>'+origin+'</p>'):''),
				'</td>',
				'<td>',
					((cmd) ? ([
						'<p><form action="httpl://cli" method="POST">',
							'<input type="hidden" name="cmd">',
							'<button type="submit" class="btn btn-default btn-xs">&crarr;</button>',
							' <button type="submit" class="btn btn-default btn-xs" formtarget="cli-update-iframe-'+iframeCounter+'"><small class="glyphicon glyphicon-refresh"></small></button>',
							' <code class="text-muted">'+util.makeSafe(cmd)+'</code>',
							' <a class="btn btn-default btn-xs" method="DELETE" href="httpl://cli/'+iframeCounter+'" target="_null">&times;</a>',
						'</form></p>'
					].join('')) : ''),
					'<iframe id="cli-update-iframe-'+iframeCounter+'" seamless="seamless" sandbox="allow-popups allow-same-origin allow-scripts" data-origin="'+origin+'"><html><body></body></html></iframe>',
				'</td>',
			'</tr>',
		'</table>'
	].join('');
	iframeCounter++;
	$('#cmd-out').prepend(html);
	$('#cmd-out .cli-update').first().find('input[name=cmd]').val(util.makeSafe(cmd));
	return $('#cmd-out iframe').first();
}

function renderIframe($iframe, html) {
	html = '<link href="css/bootstrap.css" rel="stylesheet"><link href="css/iframe.css" rel="stylesheet">'+html;
	html = '<meta http-equiv="Content-Security-Policy" content="default-src \'none\'; img-src *; style-src \'self\' \'unsafe-inline\'; font-src *;" />'+html;
	$iframe.attr('srcdoc', util.sanitizeHtml(html));
	function sizeIframe() {
		this.height = null; // reset so we can get a fresh measurement

		var oh = this.contentWindow.document.body.offsetHeight;
		var sh = this.contentWindow.document.body.scrollHeight;
		// for whatever reason, chrome gives a minimum of 150 for scrollHeight, but is accurate if below that. Whatever.
		this.height = ((sh == 150) ? oh : sh) + 'px';

		// In 100ms, do it again - it seems styles aren't always in place
		var self = this;
		setTimeout(function() {
			var oh = self.contentWindow.document.body.offsetHeight;
			var sh = self.contentWindow.document.body.scrollHeight;
			self.height = ((sh == 150) ? oh : sh) + 'px';
		}, 100);
	}
	$iframe.load(sizeIframe);

	// :TODO: can this go in .load() ?
	var attempts = 0;
	var bindPoller = setInterval(function() {
		try {
			local.bindRequestEvents($iframe.contents()[0].body);
			$iframe.contents()[0].body.addEventListener('request', iframeRequestEventHandler);

			var els = $iframe.contents()[0].body.querySelectorAll('.language-javascript');
			for (var i=0; i < els.length; i++) {
				Prism.highlightElement(els[i]);
			}

			clearInterval(bindPoller);
		} catch(e) {
			attempts++;
			if (attempts > 100) {
				console.error('Failed to bind iframe events, which meant FIVE SECONDS went by the browser constructing it. Who\'s driving this clown-car?');
				clearInterval(bindPoller);
			}
		}
	}, 50); // wait 50 ms for the page to setup
}

function iframeRequestEventHandler(e) {
	var iframeEl = $(e.target)[0].ownerDocument.defaultView.frameElement;
	var req = e.detail;
	prepIframeRequest(req, iframeEl);
	dispatchRequest(req, e.target, { $iframe: $(iframeEl) });
}

function prepIframeRequest(req, iframeEl) {
	var current_content_origin = iframeEl.dataset.origin;
	if (current_content_origin) {
		// Put origin into the headers
		req.headers.from = current_content_origin;
	}
}

function dispatchRequest(req, origin, opts) {
	opts = opts || {};
	var target = req.target; // local.Request() will strip `target`
	var body = req.body; delete req.body;

	if (!target) target = '_parent';
	if (!req.headers && target != '_null') { req.headers = {}; }
	if (req.headers && !req.headers.accept) { req.headers.accept = 'text/html, */*'; }
	req = (req instanceof local.Request) ? req : (new local.Request(req));

	// Relative link? Make absolute
	if (!local.isAbsUri(req.url)) {
		var baseurl = (origin.dataset && origin.dataset.origin) ? origin.dataset.origin : (window.location.protocol + '//' + window.location.host);
		req.url = local.joinUri(baseurl, req.url);
	}

	// Select the iframe using the target if not from within an iframe
	if (target && target.charAt(0) != '_' && !opts.$iframe) {
		opts.$iframe = $('iframe#'+target);
		target = '_self';
	}

	// Handle request based on target and origin
	var res_;
	if (target == '_self' && opts.$iframe) {
		// In-place update
		res_ = local.dispatch(req);
		res_.always(function(res) {
			var cmd;
			var from = (req.urld.protocol != 'data') ? (req.urld.protocol || 'httpl')+'://'+req.urld.authority : null;
			if (from == 'httpl://cli' && res.header('CLI-Origin')) {
				// Proxied through the command-line
				cmd = res.header('CLI-Cmd');
				from = res.header('CLI-Origin'); // use the downstream origin
			} else {
				// Not proxied through the CLI
				cmd = util.reqToCmd(req); // generate the command equivalent
			}

			var historyIndex = opts.$iframe.attr('id').slice('cli-update-iframe-'.length);
			if (historyIndex) {
				cliHistory.set(historyIndex, from, cmd, res); // replace in history
			}

			renderIframe(opts.$iframe, renderResponse(res));
			return res;
		});
	} else if (target == '_self' || target == '_parent') {
		// New iframe
		res_ = local.dispatch(req);
		res_.always(function(res) {
			var cmd;
			var origin = (req.urld.protocol != 'data') ? (req.urld.protocol || 'httpl')+'://'+req.urld.authority : null;
			if (origin == 'httpl://cli' && res.header('CLI-Origin')) {
				// Proxied through the command-line
				cmd = res.header('CLI-Cmd');
				origin = res.header('CLI-Origin'); // use the downstream origin
			} else {
				// Not proxied through the CLI
				cmd = util.reqToCmd(req); // generate the command equivalent
			}
			cliHistory.add(origin, cmd, res); // add to history

			var newIframe = createIframe(origin, cmd, res);
			renderIframe(newIframe, renderResponse(res));
			return res;
		});
	} else if (target == '_null') {
		// Null target, simple dispatch
		res_ = local.dispatch(req);
	} else {
		console.error('Invalid request target', target, req, origin);
		return null;
	}

	req.end(body);
	return res_;
}

module.exports = {
	renderIframe: renderIframe,
	prepIframeRequest: prepIframeRequest,
	dispatchRequest: dispatchRequest
};
},{"./cli/history":2,"./util.js":8}],8:[function(require,module,exports){

var lbracket_regex = /</g;
var rbracket_regex = />/g;
function makeSafe(str) {
	str = ''+str;
	return str.replace(lbracket_regex, '&lt;').replace(rbracket_regex, '&gt;');
}

var quoteRegex = /"/g;
function escapeQuotes(str) {
	return (''+str).replace(quoteRegex, '&quot;');
}

var sanitizeHtmlRegexp = /<\s*script/g;
function sanitizeHtml (html) {
	// CSP stops inline or remote script execution, but we still want to stop inclusions of scripts on our domain
	// :TODO: this approach probably naive in some important way
	return html.replace(sanitizeHtmlRegexp, '&lt;script');
}

function reqToCmd(req) {
	if (typeof req == 'string') { req = { url: req }; }
	if (!req || typeof req != 'object') return '';

	var cmd = '';
	if (req.method && req.method.toLowerCase() != 'get') {
		cmd += req.method.toUpperCase() + ' ';
	}

	var url = req.url;
	var urld = req.urld || local.parseUri(req);
	if (urld.protocol == 'httpl') url = url.slice('httpl://'.length); // remove httpl:// if its the scheme
	cmd += url;

	if (req.query && Object.keys(req.query).length) {
		cmd += '?'+local.contentTypes.serialize('application/x-www-form-urlencoded', req.query);
	}

	// Is the accept header expressable in the fat pipe?
	var isAcceptFatpipeable = (req.headers.accept && req.headers.accept.indexOf(',') === -1);
	var isDefaultAccept = (req.headers.accept == 'text/html, */*');
	for (var k in req.headers) {
		if (((isAcceptFatpipeable || isDefaultAccept) && k == 'accept') || k == 'host') continue;
		cmd += ' -'+k+'="'+escapeQuotes(req.headers[k])+'"';
	}

	if (req.body) {
		cmd += ' --'+((typeof req.body == 'object') ? JSON.stringify(req.body) : req.body);
	}

	if (isAcceptFatpipeable) {
		cmd += ' ['+req.headers.accept+']';
	}

	return cmd;
}

function escapeQuotes(str) {
	return str.replace(/"/g, '\\"');
}

module.exports = {
	makeSafe: makeSafe,
	escapeQuotes: escapeQuotes,
	sanitizeHtml: sanitizeHtml,
	reqToCmd: reqToCmd
};
},{}],9:[function(require,module,exports){
// Worker Bridge
// =============
// handles requests from the worker

module.exports = function(req, res, worker) {
	var fn = (req.path == '/') ? hostmap : proxy;
	fn(req, res, worker);
};

function hostmap(req, res, worker) {
	var via = [{proto: {version:'1.0', name:'HTTPL'}, hostname: req.header('Host')}];

	var links = [];
	links.unshift({ href: '/', rel: 'self service via', title: 'Host Page', noproxy: true });
	links.push({ href: '/{uri}', rel: 'service', hidden: true });

	// :TODO: add hosts

	// Respond
	res.setHeader('Link', links);
	res.setHeader('Via', via);
	res.header('Proxy-Tmpl', 'httpl://host.page/{uri}');
	res.writeHead(204).end();
}

function proxy(req, res, worker) {
	var via = [{proto: {version:'1.0', name:'HTTPL'}, hostname: req.header('Host')}];

	// Proxy the request through
	var req2 = new local.Request({
		method: req.method,
		url: decodeURIComponent(req.path.slice(1)),
		query: local.util.deepClone(req.query),
		headers: local.util.deepClone(req.headers),
		stream: true
	});

	// Check perms
	// :DEBUG: temporary, simple no external
	var urld = local.parseUri(req2.url);
	if (urld.protocol == 'http' || urld.protocol == 'https') {
		res.writeHead(403, 'Forbidden', { 'Content-Type': 'text/plain' });
		res.end('External requests currently disabled.');
		return;
	}

	// Set headers
	req2.header('From', 'httpl://'+worker.config.domain);
	req2.header('Via', (req.parsedHeaders.via||[]).concat(via));

	var res2_ = local.dispatch(req2);
	res2_.always(function(res2) {
		// Set headers
		res2.header('Link', res2.parsedHeaders.link); // use parsed headers, since they'll all be absolute now
		res2.header('Via', via.concat(res2.parsedHeaders.via||[]));
		res2.header('Proxy-Tmpl', ((res2.header('Proxy-Tmpl')||'')+' httpl://host.page/{uri}').trim());

		// Pipe back
		res.writeHead(res2.status, res2.reason, res2.headers);
		res2.on('data', function(chunk) { res.write(chunk); });
		res2.on('end', function() { res.end(); });
		res2.on('close', function() { res.close(); });
	});
	req.on('data', function(chunk) { req2.write(chunk); });
	req.on('end', function() { req2.end(); });
}
},{}],10:[function(require,module,exports){
// Constants
// =========
// Worker wrapper code
var whitelist = [ // a list of global objects which are allowed in the worker
	'null', 'self', 'console', 'atob', 'btoa',
	'setTimeout', 'clearTimeout', 'setInterval', 'clearInterval',
	'Proxy',
	'importScripts', 'navigator',
	'postMessage', 'addEventListener', 'removeEventListener',
	'onmessage', 'onerror', 'onclose',
	'dispatchEvent'
];
var blacklist = [ // a list of global objects which are not allowed in the worker, and which dont enumerate on `self` for some reason
	'XMLHttpRequest', 'WebSocket', 'EventSource',
	'Worker'
];
var whitelistAPIs_src = [ // nullifies all toplevel variables except those listed above in `whitelist`
	'(function() {',
		'var nulleds=[];',
		'var whitelist = ["'+whitelist.join('", "')+'"];',
		'for (var k in self) {',
			'if (whitelist.indexOf(k) === -1) {',
				'Object.defineProperty(self, k, { value: null, configurable: false, writable: false });',
				'nulleds.push(k);',
			'}',
		'}',
		'var blacklist = ["'+blacklist.join('", "')+'"];',
		'blacklist.forEach(function(k) {',
			'Object.defineProperty(self, k, { value: null, configurable: false, writable: false });',
			'nulleds.push(k);',
		'});',
		'if (typeof console != "undefined") { console.log("Nullified: "+nulleds.join(", ")); }',
	'})();\n'
].join('');
var hostUrld = local.parseUri(window.location.toString());
var host = hostUrld.protocol + '://' + hostUrld.authority;
var hostDir = host + hostUrld.directory;
var importScriptsPatch_src = [ // patches importScripts() to allow relative paths despite the use of blob uris
	'(function() {',
		'var orgImportScripts = importScripts;',
		'function joinRelPath(base, relpath) {',
			'if (relpath.charAt(0) == \'/\') {',
				'return "'+host+'" + relpath;',
			'}',
			'// totally relative, oh god',
			'// (thanks to geoff parker for this)',
			'var hostpath = "'+hostUrld.path+'";',
			'var hostpathParts = hostpath.split(\'/\');',
			'var relpathParts = relpath.split(\'/\');',
			'for (var i=0, ii=relpathParts.length; i < ii; i++) {',
				'if (relpathParts[i] == \'.\')',
					'continue; // noop',
				'if (relpathParts[i] == \'..\')',
					'hostpathParts.pop();',
				'else',
					'hostpathParts.push(relpathParts[i]);',
			'}',
			'return "'+host+'/" + hostpathParts.join(\'/\');',
		'}',
		'importScripts = function() {',
			'return orgImportScripts.apply(null, Array.prototype.map.call(arguments, function(v, i) {',
				'return (v.indexOf(\'/\') < v.indexOf(/[.:]/) || v.charAt(0) == \'/\' || v.charAt(0) == \'.\') ? joinRelPath(\''+hostDir+'\',v) : v;',
			'}));',
		'};',
	'})();\n'
].join('\n');
var bootstrap_src = whitelistAPIs_src + importScriptsPatch_src;

function lookupWorker(req, res) {
	if (req.urld.srcPath) {
		var src_url = local.joinUri(req.urld.host, req.urld.srcPath);

		// Return a server function which attempts to load the service first
		return function() {
			// Fetch over https
			var full_src_url = 'https://'+src_url;
			local.GET(full_src_url)
				.fail(function(res2) {
					if (res2.status === 0 || res2.status == 404) {
						// Not found? Try again without ssl
						full_src_url = 'http://'+src_url;
						return local.GET(full_src_url);
					}
					throw res2;
				})
				.then(function(res2) {
					// Create worker
					var server = startWorker(res2.body, req.urld.authority);
					if (server) {
						server.handleLocalRequest(req, res);
					}
				});
		};
	}
	return false;
}

function startWorker(script_src, domain) {
	try {
		// :TODO: Firefox has an issue with blob URIs and CSP
		// - Issue reported at https://bugzilla.mozilla.org/show_bug.cgi?id=929292
		var script_blob = new Blob([bootstrap_src+'(function(){'+script_src+'})();'], { type: "text/javascript" });
		var script_url = window.URL.createObjectURL(script_blob);

		// Spawn server
		return local.spawnWorkerServer(script_url, { domain: domain, log: true });
	} catch (e) { console.error(e); }
	return null;
}

module.exports = {
	lookupWorker: lookupWorker,
	startWorker: startWorker
};
},{}]},{},[6])
;