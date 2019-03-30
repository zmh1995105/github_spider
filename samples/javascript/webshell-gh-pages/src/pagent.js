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