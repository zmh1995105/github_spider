#!/usr/bin/env python


"""
Generate shellcodes and webshells quickly.
Copyright (C) 2014  Leo Depriester (leo.depriester@exadot.fr)
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
"""

import os, sys, requests, argparse, struct, pyperclip
sys.path.insert(0, sys.path[0]+"/../lib/wizhack/")
from shellcodes import *
from webshells import *
from exploits import *

def get_shellcode(target, function, clipboard):
    shellcode_class = sys.modules["shellcodes."+target.replace("/", "_")+"_"+function]
    code = []
    for c in shellcode_class.Shellcode.get():
        code.append("\\x"+c.encode("hex"))
    shellcode = "".join(code)
    if clipboard:
        pyperclip.copy(shellcode)
    print "length = %s bytes" % int(len(shellcode)/4)
    print "shellcode[]=\""+shellcode+"\""
    
def get_webshell(target, function, output, clipboard):
    webshell_class = sys.modules["webshells."+target+"_"+function]
    webshell = webshell_class.Webshell.get()
    if clipboard:
        pyperclip.copy(webshell)
    
    if output is not None:
        of = open(output, "w")
        of.write(webshell)
        of.close()
    else:
        print webshell
   
def run_exploit(target):
    exploit_class = sys.modules["exploits."+target]
    exploit = exploit_class.Exploit.run()

def check_function(util, target, function):
    functions = []
    for mod in sys.modules.keys():
        if util+"."+target.replace("/", "_") in mod and "_" in mod:
            s = mod.replace(util+".", "").split("_")
            if util == "webshells":
                functions.append(s[1])
            else:
                functions.append(s[2])
    functions = set(functions)
    if function in functions:
        return True
    else:
        print "[*] Available functions :"
        for function in functions:
            print "    %s" % function
        return False

def check_target(util, target):
    targets = []
    if util == "exploits":
        for mod in sys.modules.keys():
            if util+"." in mod and "-" in mod:
                s = mod.replace(util+".", "")
                targets.append(s)
        targets = set(targets)
    else:
        for mod in sys.modules.keys():
            if util+"." in mod and "_" in mod:
                s = mod.replace(util+".", "").split("_")
                if util == "webshells":
                    targets.append(s[0])
                else:
                    targets.append(s[0]+"/"+s[1])
        targets = set(targets)
    
    if target in targets:
        return True
    else:
        print "[*] Available targets : "
        for target in targets:
            print "    %s" % target
        return False


if __name__ == "__main__":
    utils = ["shellcode", "webshell", "exploit"]

    parser = argparse.ArgumentParser(description='Get shellcodes, webshells and exploits quickly.')
    parser.add_argument("utility", choices=utils)
    parser.add_argument("target", nargs="?", type=str)
    parser.add_argument("function", nargs="?", type=str)
    parser.add_argument("-o", "--output", type=str, help="Export result to a file") 
    parser.add_argument("-c", "--clipboard", action="store_true", help="Copy result to the clipboard")
    args = parser.parse_args()



    if args.utility == "shellcode":
        if check_target("shellcodes", args.target):
            if check_function("shellcodes", args.target, args.function):
                get_shellcode(args.target, args.function, args.clipboard)
    elif args.utility == "webshell":
        if check_target("webshells", args.target):
            if check_function("webshells", args.target, args.function):
                get_webshell(args.target, args.function, args.output, args.clipboard)
    elif args.utility == "exploit":
        if check_target("exploits", args.target):
            run_exploit(args.target)
