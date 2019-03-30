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