
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