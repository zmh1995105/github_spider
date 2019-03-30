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