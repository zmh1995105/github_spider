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