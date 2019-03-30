package main

import (
	_"github.com/MXi4oyu/Utils/config"
	"github.com/MXi4oyu/riskdetect/webshell"
	"github.com/MXi4oyu/Utils/config"
	"log"
	"fmt"
)

func main()  {

	config,err := config.NewConfig("./config.ini")
	if err!=nil{
		log.Fatal(err.Error())
	}

	v:=config.String("yara_rule_path::whitelist")
	fmt.Println(v)


	//测试yara检测
	//yarainfo:=webshell.Yara("./libs/php.yar","/var/www")

	yarainfo:=webshell.Yara("./libs/php.yar","/var/www/phpMyAdmin")

	yl:=len(yarainfo)
	for i:=0;i<yl;i++{

		fmt.Println(yarainfo[i]["type"],"----",yarainfo[i]["path"],"----",yarainfo[i]["level"],"----",yarainfo[i]["like"])

	}




	//测试ssdeep检测
	deepinfo:=webshell.Ssdeep("./libs/php.ssdeep","/var/www/","")

	dl:=len(deepinfo)

	for i:=0;i<dl;i++{
		fmt.Println(deepinfo[i]["type"],"----",deepinfo[i]["path"],"----",deepinfo[i]["level"],"----",deepinfo[i]["like"])
	}






}
