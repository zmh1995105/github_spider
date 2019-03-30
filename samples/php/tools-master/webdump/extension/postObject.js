function postObject(url, user, password, obj) {
	var json = JSON.stringify(obj);

	var req = new XMLHttpRequest();
	req.open('POST', url, true, user, password);
	req.setRequestHeader("Content-Type", "text/html;");
	
	req.addEventListener("error", function(event) {
		console.log(event);
	});

	req.send(json);
}