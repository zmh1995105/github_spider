//options.js

//chrome.storage.local.set({"url": "http://localhost"}, null);

var options = {
	server: {
		url: ""
		,user: ""
		,password: ""
	}
}


window.addEventListener("load", function(event) {
	chrome.storage.local.get(["url", "user", "password"], function(result) {
	
		if (result.url != undefined) {
			options.server.url = result.url;
		}
		if (result.user != undefined) {
			options.server.user = result.user;
		}
		if (result.password != undefined) {
			options.server.password = result.password;
		}
	
		var url = document.getElementById("input url");
		var user = document.getElementById("input user");
		var password = document.getElementById("input password");
		var save = document.getElementById("input save");

		url.value = options.server.url;
		user.value = options.server.user;
		password.value = options.server.password;
	
		save.addEventListener("click", function(event) {
			var url = document.getElementById("input url");
			var user = document.getElementById("input user");
			var password = document.getElementById("input password");
			
			options.server.url = url.value;
			options.server.user = user.value;
			options.server.password = password.value;
			
			chrome.storage.local.set(options.server, null);
		});
	});
});
