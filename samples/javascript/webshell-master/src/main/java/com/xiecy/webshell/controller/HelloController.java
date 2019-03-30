package com.xiecy.webshell.controller;

import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RestController;

/**
 * @Auther: xiecy
 * @Date: 2018/10/28 19:01
 * @Description:RequestMapping注解学习
 */
@RestController
@RequestMapping(value = "/hello")
public class HelloController {

    /**
     *
     * 功能描述:当不指定value时候,默认用根访问到该方法
     *
     * @param: []
     * @return: java.lang.String
     * @auther:
     * @date: 2018/10/28 19:44
     */
    @RequestMapping(method = RequestMethod.GET)
    public String one(){

        return "one";
    }

    /**
     *
     * 功能描述:最普通的url形式访问该方法
     *
     * @param: []
     * @return: java.lang.String
     * @auther:
     * @date: 2018/10/28 19:44
     */
    @RequestMapping(value = "/two", method = RequestMethod.GET)
    public String two(){
        return "two";
    }

    /**
     *
     * 功能描述:带占位符的url,@PathVariable将URL中占位符参数绑定到控制器处理方法的入参中
     *
     * @param: [id]
     * @return: java.lang.String
     * @auther:
     * @date: 2018/10/28 19:46
     */
    @RequestMapping(value = "/three/{id}", method = RequestMethod.GET)
    public String three(@PathVariable String id){
        return id;
    }

    /**
     *
     * 功能描述: 指定多个url匹配
     *
     * @param: []
     * @return: java.lang.String
     * @auther:
     * @date: 2018/10/28 19:59
     */
    @RequestMapping(value = {"/four","/four/1"}, method = RequestMethod.GET)
    public String four(){
        return "four";
    }
}