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