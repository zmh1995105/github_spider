package webshell

import (
	"github.com/MXi4oyu/Utils/subprocess"
	"github.com/MXi4oyu/Utils/cnencoder/gb18030"
	"github.com/MXi4oyu/Utils/walkpath"
	"github.com/MXi4oyu/gossdeep/deepapi"
	"context"
	"time"
	"strings"
	"os"
	"bufio"
	"io"
	"fmt"
	"strconv"
)

var whitelists = make([] string,50,100)


func Yara(rule_path,dir_path string) ([]map[string]string)  {


	funny_res := make([]map[string]string,0,100)


	ctx, cancel := context.WithTimeout(context.Background(), time.Duration(6000)*time.Second)
	defer cancel()

	str,err:=subprocess.RunCommand(ctx,"yara",rule_path,"-r",dir_path)
	if err!=nil{
		fmt.Println(err.Error())
	}

	line:=gb18030.Decode(str)

	s:=strings.Split(line,"\n")

	for _,file_dir:=range s{

		var file_type,file_path string

		if len(file_dir)>0{

			res:=make(map[string]string)

			ss:=strings.Split(file_dir," ")
			file_type=ss[0]
			file_path=ss[1]

			if file_type[0:5]=="safe_"{

				//白名单
				continue

			}else{

				res["type"]=file_type
				res["path"]=file_path
				res["level"]="danger"
				res["like"]="100"

				for _,wf:= range whitelists{

					if wf != file_path{
						
					}
				}

				funny_res=append(funny_res,res)
			}


		}

	}

	return funny_res

}

var filehashmap = make([]string,0,100)

//处理每一行
func processLine(line []byte)  {

	linestr:=string(line)
	linearray:=strings.Split(linestr,",")
	linehash:=linearray[0]
	filehashmap=append(filehashmap,linehash)

}

//逐行读取文件
func FileReadLine(filepath string,hookfunc func([] byte)) error  {

	f,err:=os.Open(filepath)
	if err!=nil{
		return err
	}

	defer f.Close()

	mybufReader:=bufio.NewReader(f)

	for{
		line,err:=mybufReader.ReadBytes('\n')
		hookfunc(line)

		if err!=nil{
			if err==io.EOF{
				return nil
			}

			return err
		}
	}

	return nil

}


func Ssdeep(rule_path,dir_path,suffix string) ([]map[string]string)  {

	funny_res := make([]map[string]string,0,100)

	//提取所有样本文件中的hash
	FileReadLine(rule_path,processLine)
	//fmt.Println(filehashmap)

	//遍历要检测的目录下的所有文件
	files,err:=walkpath.WalkDir(dir_path,suffix)
	if err!=nil{
		fmt.Println(err.Error())
	}

	//提取文件的hash值

	for _,f :=range files{

		//fmt.Println(f)
		hashvalue:=deepapi.Fuzzy_hash_file(f)

		//遍历filehashmap，对比相似度

		for _,m := range filehashmap{

			res:=make(map[string]string)

			res["type"]="webshell"
			res["path"]=f
			if len(m)>5{

				similary:=deepapi.Fuzzy_compare(m,hashvalue)
				res["like"]=strconv.Itoa(similary)
				if similary>30{

					simi:=similary/10

					switch simi {

					case 3,4,5:
						res["level"]="info"
						funny_res=append(funny_res,res)
						break
					case 6,7:
						res["level"]="warning"
						funny_res=append(funny_res,res)
						break
					case 8,9,10:
						res["level"]="danger"
						funny_res=append(funny_res,res)
						break
					}

				}else{

				}
			}
		}

	}



	return funny_res
}
