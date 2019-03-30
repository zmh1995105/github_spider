Webshell node.js SDK
====================

The easiest way to use Webshell in javascript using Node.js


I - Create an app on [webshell](http://webshell.io)
------------------------------

To use Webshell, you have to create an app in your [Dashboard](http://webshell.io/dashboard) which will generate valid API Keys.

II - Setup webshell.js
----------------------

The easier way to install this sdk is to use npm:

`````
npm install wsh
`````

You can also clone this repo or download the latest release, to add it into your `node_modules` folder.

III - Hello world app
---------------------

This is a simple app using Webshell. To run this sample, you have to replace `MY_WEBSHELL_PUBLIC_KEY`, `MY_WEBSHELL_SECRET_KEY`, `MY_DOMAIN` with valid infos from the registered app.

`````js
var wsh = require('wsh');

// init webshell with authentications keys
wsh.init({
  key:"MY_WEBSHELL_PUBLIC_KEY",
	secret:"MY_WEBSHELL_SECRET_KEY",
	domain:"MY_DOMAIN" // e.g: mysite.com
});

// execute webshell code
var wshcall = wsh.exec({
	code: function() {
		for (var i in args.myarr)
			echo(args.myarr[i]);
		dump(args);
		return apis.tumblr.getPosts({"base-hostname": "webshellnews.tumblr.com"}, {view:null});
	},
	args: {myarr: ["hello", "world"]}
});

// set events
wshcall.on('error', function(err) {
	console.log('wsh error:', err);
});
wshcall.on('process', function(data, meta) {
	console.log('processing', {
		'data': data,
		'meta': meta
	});
});
wshcall.on('success', function(res) {
	console.log('succeeded, result:', res);
});

`````

Pretty simple hm ?! You can call any other APIs on the platform in the same way. The javascript given in the `code` attribute of `wsh.exec()` is processed on our server and we retrieve all kind of data for you.

SDK Reference
-------------

### wsh.init({key, secret, csid, domain})
All these parameters must be strings and are optional.
After initializing your `wsh` object with the `wsh.init`, you can use `wsh.exec` with these default parameters.

### wsh.exec({...}) or wsh.exec(code)
This method executes some code on webshell. The only required parameter (if you have init wsh before) is `code`. This can be directly the first argument, or a key of the given object.
The object can take these parameters:

`````js
wsh.exec({
  code: function() {
    // some code which have be executed by Webshell
  },
  args: ... // data to use in the script
  here: {latitude, longitude} // only if you wish to manage geolocation of your users
  
  csid: "..."      //   You can manage a webshell session by its key
  session: {}      //   or any storing object

  key: "..."       //   These parameters are authentications informations
  secret: "..."    //   and only required if you did not set them with wsh.exec
  domain: "..."    //
})
`````

*code* can be a string of the javascript, or a function with the javascript which need to be executed by Webshell.

`wsh.exec` returns a WebshellCall object used to handle some events specifically to a call.

### Events

The `wsh` object and the WebshellCall objects can emit several events:

#### wsh.on('process', ...)

When the sdk receives a view from the server.

#### wsh.on('success', ...)

When an execution finishes and returns a result.

#### wsh.on('error', ...)

When any error on webshell or sdk occurs.


About webshell scripts
----------------------

You can try online your Webshell code in the [API Editor](http://webshell.io/editor) and include your script using the fs object inside your webshell code (see [builtins/fs()](http://webshell.io/docs/reference/v/builtins))


Read more information about Webshell in the [documentation](http://webshell.io/docs)
