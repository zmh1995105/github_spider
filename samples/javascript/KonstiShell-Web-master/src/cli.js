wd = "~"
currentUser = "local"
host = "KServer"
admin = false
user_History = []
command_history = []

users = {
  root: {
    name: "root",
    password: "AAPnSgAELxvvtLj70gRQnw==", //password: root
    isAdmin: true
  },
  local: {
    name: "local",
    password: "AAONkAADgxhKiYiaik9OhQ==", //password: local
    isAdmin: false
  }
}

function $$id(id) {return document.getElementById(id);}
function $$class(id) {return document.getElementsByClassName(id);}
function calcStyle() {
  width = $$id('pr').offsetWidth + 32;
  $$id('prompt-in-val').setAttribute("style",'width: calc(100% - '+width+'px)');
}
const cli = {
  users: {},
  input: {}
};

cli.init = function() {
  $$id('prompt-in').addEventListener('submit', function(evt){cli.input.collect(evt)})
  user_History[0] = currentUser;
  $$class('user')[$$class('user').length-1].innerHTML = currentUser;
  $$id('host').innerHTML = host;
  calcStyle();
}

cli.input.update = function() {
  $$class('user')[$$class('user').length-1].innerHTML = currentUser;
  $$id('host').innerHTML = host;
  if (admin) {$$id('ic').innerHTML = "#";} else {$$id('ic').innerHTML = "$";}
  calcStyle();
}

cli.users.authenticate = function(username, password) {
  pw = users[username].password;
  var decrypted = decrypt(password, pw).trim();
  if (decrypted == password) {
    return true;
  } else {
    return false;
  }
}

cli.users.cryptPassword = function(password) {
  let encrypted = encrypt(password, password);
  return encrypted;
}

cli.input.collect = function(evt) {
  evt.preventDefault();
  ic ="$"
  if (admin) {ic ="#"}
  $$id('output').innerHTML += "<br /><span class=\"prompt-row\"><span class=\"prefix\">["+currentUser+"@"+host+" "+wd+"]</span>"+ic+" " + $$id('prompt-in-val').value;
  if ($$id('prompt-in-val').value.trim().length > 0) {
    cli.input.eval($$id('prompt-in-val').value.trim());
  }
  $$id('prompt-in-val').value = "";
  window.scrollTo(0, document.body.scrollHeight);
}

cli.input.eval = function(input) {
  command = input.split(" ")[0];
  argument = input.split(" ").slice(1);
  if (input != command_history[command_history.length-1]) {
    command_history[command_history.length] = input;
  }
  curserPos = command_history.length;
  try {
    shell.command[command](argument);
  } catch (e) {
    shell.command.error("Konsti Shell: -command "+command+" not found");
  } finally {
    cli.input.update();
  }
}
