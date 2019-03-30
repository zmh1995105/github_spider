var dump = {
	save: function() {
		dump.getDataFromPage()
	}
	
	,obj: {}
	,getDataFromPage: function() {
		var details = {
			"file": "inject.js"
		};
		chrome.tabs.executeScript(null, details, function(result) {
			dump.obj = result[0];
			chrome.storage.local.get(["url", "user", "password"], function(result) {
			
				var url = "";
				var user = "";
				var password = "";
				var obj = {};
			
				if (result.url != undefined) url = result.url;
				if (result.user != undefined) user = result.user;
				if (result.password != undefined) password = result.password;
				if (dump.obj != undefined) obj = dump.obj
				
				postObject(url, user, password, obj);
			});
			
		});
	}
};
