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