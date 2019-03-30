//Those two variables aren't used at the moment
//They'll be used when the command-history is added.
var cmdhistory = [];
var cmdindex = 0;
//The environment. Per default it only contains the current path
//...which is set to the "root" of the console-specific filesystem.
var environment = {"path":"/"};

$(document).ready(function(){
	//Adding an event-handler for keyup-events:
    $("#shell").keyup(function(event) {
       if(event.which == 13) //Return is pressed
       {
    	   //The shell-input is splitted
    	   var lines  = $("#shell").val().split("\n");
    	   //This is the line submitted most recently
           var input  = lines[lines.length-2];
           //The command which is entered (i.e. the first part of the last
           //input line up to the first space)
           var cmd 	  = input.split(" ")[1];
           //Lets build the params.
           var params = "";
           var parts  = input.split(" ");
           for(i=2;i<parts.length;i++)
           {
        	   params += parts[i]+" ";
           }
           parts.shift(); //remove the command itself.
           //This is not used at the moment...
           cmdhistory.push(parts.join(" "));
           cmdindex = cmdhistory.length;
           //Lets build the environment...
           var environmentString = "{";
           for(envvar in environment)
           {
        	   environmentString += '"'+envvar+'":"'+eval("environment."+envvar)+'",';
           }
           environmentString = environmentString.substr(0,environmentString.length-1)+"}";
         
           /*
            * Now the interaction with the backend starts
            * The interaction works this way: The app_proxy.php is called with
            * the submitted command and parameters and the current environment.
            * The response is a json-object, containing a string to be displayed
            * in the shell and the environment-object (JSON).
            * Then the environment is reloaded to reflect the returned environment.
           */
           $.getJSON("app_proxy.php",
        		   {'app':cmd,'environment':environmentString,'params':params},
        		   function(data) {
               environment = data.environment;
        	   $("#shell").val($("#shell").val()+data.data);
               $("#shell").val($("#shell").val()+environment.path+"> ");
               $("#shell").scrollTo("100%",150);
           });
//Alternative request for debugging, if Response-JSON is invalid.
/*
           $.get("app_proxy.php",
        		   {'app':cmd,'environment':environmentString,'params':params},
        		   function(data) {
        			   alert(data);
           });
*/           
       }
    });
});