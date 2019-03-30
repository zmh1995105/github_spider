var util = require("util");
var events = require("events");
var http = require('http');
var querystring = require('querystring');

function Webshell() {
	events.EventEmitter.call(this);
	this._baseUrl = 'api.webshell.io';
	this._apiKey = '';
	this._secretKey = '';
	this._csid = '';
	this._domain = '';
	this.on('error', function() {});
}

var callnb = 1;
function WebshellCall(opts) {
	events.EventEmitter.call(this);
	this._opts = opts;
	this._callid = callnb++;
	this.on('error', function() {});
}

util.inherits(Webshell, events.EventEmitter);
util.inherits(WebshellCall, events.EventEmitter);

Webshell.prototype.init = function(options) {
	this._apiKey = options.key || this._apiKey;
	this._secretKey = options.secret || this._secretKey;
	this._csid = options.csid || this._csid;
	this._domain = options.domain || this._domain;
	return this;
}

Webshell.prototype.exec = function(options) {
	var self = this;

	var wshcall = new WebshellCall(options);
	function emit() {
		wshcall.emit.apply(wshcall,arguments);
		self.emit.apply(self,arguments);
	}

	process.nextTick(function() {
		if ( ! self._apiKey && ! options.key) {
			emit('error', 'You must set parameter "key"');
			return;
		}

		if ( typeof options == 'string') {
			if (options[0] == '#')
				options = { 'hash': options.substr(1) };
			else
				options = { 'code': options };
		}

		if ( ! options.code && ! options.hash) {
			emit('error', 'You must set parameter "code" or "hash"');
			return;
		}

		// guess client session id
		var csid = options.csid || self._csid || options.session && options.session._wsh_csid || '';

		// construct request
		params = {};
		bodyparams = {};

		params.domain = options.domain || self._domain;
		if ( ! params.domain) {
			emit('error', 'You must set parameter "domain"');
			return;
		}

		if (options.hash)
			params.hash = options.hash;
		else if (options.code)
		{
			if (typeof options.code == 'string' && options.code.match(/^\#\![ \t]+[a-zA-Z_]+[ \t]*[\r\n]/))
				bodyparams.code = options.code
			else
			{
				if (typeof options.code == 'string')
					bodyparams.code = options.closure ? '(function() {' + options.code.trim() + "\n})();" : options.code.trim();
				else if (typeof options.code == 'function')
					bodyparams.code = '(' + options.code.toString().trim() + ')();';
				else
				{
					emit('error', 'Bad type for parameter "code"');
					return;
				}
			}
		}
		else
		{
			emit('error', 'You must provide code parameter');
			return;
		}
		params.key = options.key || self._apiKey || undefined;
		bodyparams.secret = options.secret || self._secretKey || undefined;
		if (csid)
			bodyparams.csid = csid;
		if (options.version)
			params.version = options.version;
		if (options.args)
			bodyparams.args = JSON.stringify(options.args);
		params.here = options.here || (bodyparams.code && bodyparams.code.indexOf('here()') >= 0);
		params.min = false;

		bodyparamsstr = JSON.stringify(bodyparams);

		// execute request
		var reqoptions = {
			host: self._baseUrl,
			method: 'POST',
			path: '/?' + querystring.stringify(params),
			headers: { 'Content-Type':'application/json', 'Content-Length':new Buffer(bodyparamsstr,'utf8').length, 'Referer': 'http://' + params.domain }
		};

		var req = http.request(reqoptions, function(res) {
			content = '';
			res.setEncoding('utf8');
			res.on('data', function(chunk) { content += chunk });
			res.on('error', function(err) {
				emit('error', err)
			});
			res.on('end', function() {
				if ( ! content)
					return;
				try {
					data = JSON.parse(content);
				}
				catch (e) {
					emit('error', e.message);
					return;
				}
				var res, meta;
				if ( ! Array.isArray(data))
				{
					if (typeof data == "object" && data != null && typeof data.data == "object" && data.data != null && data.data.error)
						emit('error', data._meta.view);
					else
						emit('error', 'Bad response from server');
					return;
				}

				var resultval = data.shift();
				for (var i in data) {
					var value = data[i];
					if (typeof value == 'object' && value != null && value._meta) {
						res = value.data;
						meta = value._meta;
					} else {
						res = value;
						meta = null;
					}

					if (meta && meta.cookie_add) {
						emit('setSession', meta.cookie_add.sid);
						if (options.session)
							options.session._wsh_csid = meta.cookie_add.sid;
					} else {
						if (typeof res == 'object' && res != null && res.error && typeof meta == 'object' && meta != null)
							emit('error', meta.view);
						else
							emit('process', res, meta);
					}
				}
				emit('success', resultval);
			});
		});
		req.end(bodyparamsstr);
	});
	return wshcall;
}

module.exports = new Webshell();
