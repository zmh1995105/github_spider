var shell = {
  command: {}
};
shell.command.error = function(output) {$$id('output').innerHTML += "<br /><span class=\"error\">"+output+"</span>";}
shell.command.warn = function(output) {$$id('output').innerHTML += "<br /><span class=\"warn\">"+output+"</span>";}
shell.command.log = function(output) {$$id('output').innerHTML += "<br /><span>"+output+"</span>";}
console.error = function(err) {shell.command.error("JavaScript: "+err)}
console.warn = function(err) {shell.command.warn("JavaScript: "+err)}
console.log = function(err) {shell.command.log("JavaScript: "+err)}

shell.command.sudo = function(args) {
  if (args[0]) {
    if (args[0] == "--help" || args[0] == "--h") {
      shell.command.log(help["sudo"]);
    } else {
      if (cli.users.authenticate("root", args[0])) {
        if (args[1]) {
          switch (args[1]) {
            case 'su':
              admin = true; user_History[user_History.length] = currentUser; currentUser = "root";
              break;
            default:
              shell.command[args[1]](args.slice(2), true);
          }
        } else {
          shell.command.log(help["sudo"]);
        }
      } else {
        shell.command.error("Konsti Shell: -The enterd password is wrong.");
      }
    }
  } else {shell.command.log(help["sudo"]);}
}

shell.command.echo = function(output) {
  if (output[0] == "--help"|| output[0] == "--h") {
    shell.command.log(help["echo"]);
  } else {
    shell.command.log(output.join(" "));
  }
}

shell.command.welcome = function(output) {$$id('output').innerHTML ="Konsti Shell \\(°_°)/";}

shell.command.cls = function(args) {shell.command.clear(args);}
shell.command.clear = function(args) {
  if (args[0] == "--help"|| args[0] == "--h") {
    shell.command.log(help["clear"]);
  } else {
    $$id("output").innerHTML = "";
  }
}

shell.command.logout = function(output) {
  if (output[0] == "--help"|| output[0] == "--h") {shell.command.log(help["logout"]);}
  else {
    if (user_History.length > 1 ) {
      currentUser = user_History[user_History.length-2];
      user_History.splice(user_History.length-1, 1);
      admin = users[currentUser].isAdmin;
    }
  }
}

shell.command.js = function(output, iAdmin) {shell.command.javascript(output, iAdmin)}
shell.command.javascript = function(output, iAdmin) {
  if (output[0] == "--help"|| output[0] == "--h") {shell.command.log(help["JavaScript"]);}
  else {
    if (admin == true || iAdmin) {eval(output.join(" "));}
    else {shell.command.error("You have no permission to perform the JavaScript command");}
  }
}
