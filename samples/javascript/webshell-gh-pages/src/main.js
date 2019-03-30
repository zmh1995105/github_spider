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