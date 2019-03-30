var uname = ["guest", "hacker", "user", "you\'re a nerd", "weirdo", "you should login", "type \'login\'", "god", "the GOAT", "23984", "If you\'re reading this it\'s too late", "loser", "such a nerd", "what a nerd", "who uses cmd anymore?", "I didn't make this nickname", "there are tons of premade names for guests", "insert random username here", "oops thats an error", "error", "null", "NaN", "undefined", "don\'t do it", "hjsd^&^@#(#@(&*BDSDsd783424", "distraction", "&ltscript&gthack \'em&lt/script&gt"];

function handleConnectionChange(event){
    if(event.type == "offline"){
        print("you are offline. some functionality may be unavailable");
    }
    if(event.type == "online"){
        print("you are back online");
    }

    console.log(event.type + " at " + new Date());
}
window.addEventListener('online', handleConnectionChange);
window.addEventListener('offline', handleConnectionChange);


function CharCode(event) {
    var go = document.getElementById("modal").style.display;
    if (go !== "block") {
        var x = event.which || event.keyCode;
        if (x !== 13) {
            var res = String.fromCharCode(x);
            var words = document.getElementById("text").innerHTML;
            document.getElementById("text").innerHTML = words + res;
        }
    }
}
function KeyCode(event) {
    var go = document.getElementById("modal").style.display;
    if (go !== "block") {

        var x = event.which || event.keyCode;
        var words = document.getElementById("text").innerHTML;
        if (x == 8) {
            document.getElementById("text").innerHTML = words.slice(0, -1);
        } else if (x == 13) {
            if (words.length > 0) {
                submit();
            }
        }
    }
}
function submit() {
    var words = document.getElementById("text").innerHTML;
    print("<b>" + words + "</b>");
    var spliced = words.split(" ");
    var main = spliced[0];
    print(program(main));
    clear();
}
function program(main) {
    if (main === "date") {
        return getDate();
    } else if (main === "computer") {
        return computer();
    } else if (main === "git") {
        return git();
    } else if (main === "help") {
        return help();
    } else if (main === "login") {
        return login();
    } else if (main === "name") {
        return name();
    } else if (main === "network") {
        network();
        return "running tests..."
    } else if (main === "options") {
        options();
        return "options processing...";
    } else if (main === "output") {
        var words = document.getElementById("text").innerHTML;
        var spliced = words.split(" ");
        var main2 = spliced[1];
        if (main2 !== "network") {
            if (main2 !== "login") {
                if (main2 !== "name") {
                    document.getElementById("output").innerHTML = program(main2);
                    return "outputting " + main2 + " on the right-side of the screen"
                } else {
                    return "\'login\' and \'name\' functions do not work when called under the \'output\' command";
                }
            } else {
                return "\'login\' and \'name\' functions do not work when called under the \'output\' command";
            }
        } else {
            document.getElementById("output").innerHTML = "";
            network("right");
            return "outputting network on the right-side of the screen"
        }
    } else if (main === "refresh") {
        location.reload();
        return "refreshing...";
    } else {
        return "The \'" + main + "\' command does not exist or is mistyped. Type \'help\' for a full list of supported commands and how to use them.";
    }
}
function print(text, side) {
    if (side === "right") {
        var prev = document.getElementById("output").innerHTML;
        document.getElementById("output").innerHTML = prev + "<br><br>" + text;
        $(document).scrollTop($(document).height());
    } else {
        var prev = document.getElementById("previous").innerHTML;
        document.getElementById("previous").innerHTML = prev + "<br><br>" + text;
        $(document).scrollTop($(document).height());
    }
}
function clear() {
    document.getElementById("text").innerHTML = "";
}
function help() {
    return "computer - info about your machine including OS, and browser data<br><br>date - the current date and time<br><br>git [command] [url] - performs a git command like clone or push on a specific repository<br><br>help - full list of commands and syntax<br><br>login [name] - changes the current \'" + document.getElementById("input").innerHTML + "\' name to one of your choice<br><br>name [set, random, or ip] [name] - choose your username with \'name set \' (you\'re username here), set a random one with \'name random\', or display your public ip as your username by typing \'name ip\'<br><br>network - returns information about your internet connection including your public ip address and your connection speed<br><br>options [bg, setup, or reset] [background color] - sets a hex or text value as the page\'s background color, opens a popup to choose your WebShell\'s appearance, or resets all options to default<br><br>output [command] - type \'output\' followed by any command as usual to display the results on the right side of the screen<br><br>refresh - refreshes the page";
}
function setup() {
    print("opening options page...");
    document.getElementById("modal").style.display = "block";

}
function closeM() {
    var bg = document.getElementById("bg").value;
    var txt = document.getElementById("txt").value;
    var fs = document.getElementById("fs").value;
    var f = document.getElementById("f").value;
    document.body.style.backgroundColor = bg;
    document.body.style.color = txt;
    document.body.style.fontSize = fs + "px";
    document.body.style.fontFamily = f;
    document.getElementById("modal").style.display = "none";
}
function login() {
    var words = document.getElementById("text").innerHTML;
    if (words != "") {
        var sep = words.split(" ");
        var more = sep[1];
        if (typeof more == "undefined" || more === "") {
            return "Please type \'login\' followed by your desired username and then press enter.";
        } else {
            var splited = words.slice(5, words.length);
            document.getElementById("input").innerHTML = splited + ">";
            return "Username changed to " + splited + ".";
        }
    } else {
        return "error processing login command. Please report the bug <a href=\'https://github.com/EricAndrechek/WebShell/issues\'>here</a>.";
    }
}
function options() {
    var change1 = document.body.style.backgroundColor;
    var words = document.getElementById("text").innerHTML;
    if (words != "") {
        var sep = words.split(" ");
        var more = sep[1];
        if (typeof more == "undefined" || more === "") {
            print("Please type \'options\' followed by your desired option including: \'bg\'(or \'backgroud\') \'setup\', or \'reset\'.");
        } else if (more === "bg" || more === "background") {
            if (typeof sep[2] == "undefined" || sep[2] === "") {
                print("please type \'options bg(or background) \' [followed by your desired color in hex or text.");
            } else {
                document.body.style.backgroundColor = sep[2];
                var change2 = document.body.style.backgroundColor;
                if (change1 !== change2) {
                    print("background color changed to " + sep[2]);
                } else {
                    print("error processing color command. This could be because the color you have just entered is not different from the previous color. Try again with a hex or text value. It that doesn\'t work, please report the bug <a href=\'https://github.com/EricAndrechek/WebShell/issues\'>here</a>.");
                }
            }
        } else if (more === "setup") {
            setup();
        } else if (more === "reset") {
            location.reload();
            print("all options reset to default");
        } else {
            print("\'" + more + "\' is an invalid \'set\' command. type \'set\' or \'help\' to see the proper commands and syntax.");
        }
    } else {
        print("error processing options command. Please report the bug <a href=\'https://github.com/EricAndrechek/WebShell/issues\'>here</a>.");
    }
}
function script() {
    return "doesn't do anything yet";
}
function getDate() {
    return new Date();
}
function git() {
    return "how we plan to implement git: https://github.com/creationix/js-git";
}
function network(side) {
    if (navigator.onLine) {
        print("connected to internet", side)
        $.getJSON('https://api.ipify.org?format=jsonp&callback=?', function(data) {
            var object = JSON.stringify(data, null, 2);
            print("public ip is: " + object.slice(11, object.length-3), side);
            print("gathering connection speed info. may take several seconds...", side)
        });
        var imageAddr = "http://www.kenrockwell.com/contax/images/g2/examples/31120037-5mb.jpg";
        var downloadSize = 4995374;
        function InitiateSpeedDetection() {
            setTimeout(MeasureConnectionSpeed, 1);
        };
        InitiateSpeedDetection();
        function MeasureConnectionSpeed() {
            var startTime, endTime;
            var download = new Image();
            startTime = (new Date()).getTime();
            var cacheBuster = "?nnn=" + startTime;
            download.src = imageAddr + cacheBuster;
            download.onload = function () {
                endTime = (new Date()).getTime();
                showResults();
            }
            download.onerror = function (err, msg) {
                print("error running speed test. click <a href = \' https://github.com/EricAndrechek/WebShell/issues \' >here</a> to report the error. be sure to use the following error messages in your bug submition: codes: " + err + " " + msg, side);
            }
            function showResults() {
                var duration = (endTime - startTime) / 1000;
                var bitsLoaded = downloadSize * 8;
                var speedBps = (bitsLoaded / duration).toFixed(2);
                var speedKbps = (speedBps / 1024).toFixed(2);
                var speedMbps = (speedKbps / 1024).toFixed(2);
                print("your connection speed is " + speedMbps + " Mbps", side);
            }
        }
    } else {
        print("no internet connection", side)
    }
}
function computer() {
    var txt = "";
    txt += "Browser CodeName: " + navigator.appCodeName;
    txt += "<br>Browser Name: " + navigator.appName;
    txt += "<br>Browser Version: " + navigator.appVersion;
    txt += "<br>Cookies Enabled: " + navigator.cookieEnabled;
    txt += "<br>Browser Language: " + navigator.language;
    txt += "<br>Browser Online: " + navigator.onLine;
    txt += "<br>Platform: " + navigator.platform;
    txt += "<br>User-agent header: " + navigator.userAgent;
    return txt;
}
function name(option) {
    if (option === "ran") {
        document.getElementById("input").innerHTML = uname[Math.floor(Math.random() * uname.length)] + ">";
    } else {
        var words = document.getElementById("text").innerHTML;
        if (words != "") {
            var sep = words.split(" ");
            var more = sep[1];
            if (typeof more == "undefined" || more === "") {
                return "Please type \'name\' followed by your desired username option including: \'random\', \'set\', or \'ip\'.";
            } else if (more === "set") {
                var sep2 = words.split(" ");
                var more2 = sep2[2];
                if (typeof more2 == "undefined" || more2 === "") {
                    return "please type \'login\' (you\'re name here) or \'name set\' (you\'re name here) to set a custom name"
                } else {
                    var splited2 = words.slice(8, words.length);
                    document.getElementById("input").innerHTML = splited2 + ">";
                    return "Username changed to " + splited2 + ".";
                }
            } else if (more === "ip") {
                $.getJSON('https://api.ipify.org?format=jsonp&callback=?', function(data) {
                    var object = JSON.stringify(data, null, 2);
                    document.getElementById("input").innerHTML = object.slice(11, object.length-3) + ">"
                });
                if (!navigator.onLine) {
                    document.getElementById("input").innerHTML = "offline" + ">";
                    return "it appears you are offline. for more information type \'network\'";
                } else {
                    return "your public ip address has been set as your username"
                }
            } else if (more === "random" || more === "ran" || more === "rand") {
                document.getElementById("input").innerHTML = uname[Math.floor(Math.random() * uname.length)] + ">";
                return "new random name set";
            } else {
                return "\'" + more + "\' is an invalid \'name\' command. type help for more info on how to use \'name\'"
            }
        } else {
            return "error processing name command. Please report the bug <a href=\'https://github.com/EricAndrechek/WebShell/issues\'>here</a>.";
        }
    }
}