'use strict';

//websocket初始化
let socket = io(location.origin);

$(document).ready(() => {
    //生成序列号
    $("th[scope='row']").each((i,e) => {
        $(e).text(i+1)
    });

    //省略网址、密码超出范围后的字符串
    $("tbody tr").each((i,e) => {
        $(e).find("td:first").text(fun.curStr($(e).find("td:first"),90));
        $(e).find("td:eq(1)").text(fun.curStr($(e).find("td:eq(1)"),20));
    })

    $(".list-group a:first").click(() => {
        clearAddSiteInfo();
    })

    //站点地址的文件类型判断
    $(".site-url").blur((e) => {
        let site_url = e.target.value;
        let fileType;
        if(site_url == ""){
			return false;
		}
        let site_url_fileType = fun.parseUrl(site_url).file.split(".").pop();
        if(site_url_fileType.indexOf("?") != "-1"){
            site_url_fileType = site_url_fileType.split("?")[0];
        }
        configOption.scriptFile.forEach(function(i, e){
            if(i == site_url_fileType.toUpperCase()){
                fileType = i;
            }
        })
        if(fileType){
            $(".site-url-fileType").text(fileType);
        }else{
            $(".site-url-fileType").text("语言");
        }
    })

    //自主选择站点地址的文件类型
    $(".dropdown-menu li").each((i,e) => {
        $(e).click(() => {
            $(".site-url-fileType").text($(e).text());
        })
    })

    //隐藏/显示 添加站点时的密码
    $(".site-password-toggle").click(() => {
        let inputType = $(".site-password").attr("type");
        if(inputType == "password"){
            $(".site-password").attr("type","text");
        }else{
            $(".site-password").attr("type","password");
        }
    })

    //发送添加站点信息
    $(".send-site-info").click(() => {
        $(".add-site-callback-info").text("");
        let site_url = $(".site-url").val();
        let site_url_fileType = $(".site-url-fileType").text();
        let site_password = $(".site-password").val();
        if(site_url == "" || !regex.checkUrl.test(site_url)){
            $(".add-site-callback-info").text("站点地址不规范，请检查后填入");
            return false;
        }
        if(site_url_fileType == "" || !configOption.scriptFile.some((e) => {return (e == site_url_fileType)})){
            $(".add-site-callback-info").text("站点语言类型不规范，请检查后填入");
            return false;
        }
        if(site_password == ""){
            $(".add-site-callback-info").text("管理密码不规范，请检查后填入");
            return false;
        }
        $(".add-site-callback-info").text("正在验证站点地址是否存在");
        socket.emit('addsite',{
            site_url: site_url,
            site_url_fileType: site_url_fileType,
            site_password: site_password
        })
        socket.on('addsite callback', function(data){
            $(".add-site-callback-info").text(data.msg);
        })
    })

    //清空上次添加站点的信息
    let clearAddSiteInfo = () => {
        $(".site-url").val("");
        $(".site-url-fileType").text("语言");
        $(".site-password").val("")
        $(".add-site-callback-info").text("");
    }
})