import request from 'superagent';

/**
 * 判断状态码
 * @author Black-Hole <158blackhole@gmail.com>
 * @description 判断状态码属于哪一种，并返回状态码信息
 * @function
 * @param {string|number} status - 要进行判断的状态码
 * @returns {String} 返回判断后的信息
 */
global.CheckStatusCode = status => {
    let StatusCode = status.toString().substring(0,status.toString().length-1);
    let statusInfo;
    switch (StatusCode) {
        case '20':
            statusInfo = {
                status: '20x',
                msg: "网页存在，开始验证密码正确性"
            };
            break;
        case '30':
            statusInfo = {
                status: '30x',
                msg: "状态码返回30x，页面可能是重定向，请检查后重试"
            };
            break;
        case '40':
            statusInfo = {
                status: '40x',
                msg: "状态码返回40x，可能是页面可能不存在，请检查后重试"
            };
            break;
        case '41':
            statusInfo = {
                status: '41x',
                msg: "状态码返回41x，可能是服务器验证数据包出现问题，请检查后重试"
            };
            break;
        case '42':
            statusInfo = {
                status: '41x',
                msg: "状态码返回41x，可能是当前资源被锁定，请检查后重试"
            };
            break;
        case '50':
            statusInfo = {
                status: '50x',
                msg: "状态码返回41x，可能是服务器出现错误，请检查后重试"
            };
            break;
        default:
            statusInfo = {
                status: err.status,
                msg: "未知状态码，请检查后重试"
            };
            break;
    }
    return statusInfo;
}

/**
 * 检测站点状态
 * @author Black-Hole <158blackhole@gmail.com>
 * @description 检测站点的状态码是否为200
 * @function
 * @param {string} url - 要进行检测的站点地址
 * @returns {String} 返回检测后的状态
 */
global.checkSite = async url =>{
    return new Promise((resolve, reject) => {
        request.get(url, function(err, res){
            resolve(CheckStatusCode(res.status));
        });
    });
}

/**
 * 检测站点密码是否正确
 * @author Black-Hole <158blackhole@gmail.com>
 * @description 检测站点的密码是否正确
 * @function
 * @param {string} url - 要进行检测的站点地址
 * @param {string} password - 进行检查的密码
 * @returns {String} 返回检测后的状态
 */
global.checkSitePassword = async (url,password) => {
    let siteStatus,feasibleMethods = [];
    for(let i = 0;i < option.methods.length;i++){
        let sendParams = (option.methods[i] == 'get')?'query':'send';
        await new Promise((resolve) => {
            request[option.methods[i]](url)
            [sendParams](password+"="+sendCommand.checkPassword)  //要发送的验证命令
            .end((err,res) => {
                if(err != null){
                    siteStatus = CheckStatusCode(res.status);
                    resolve();
                }
                if(res.text.indexOf(option.onlyString) != -1){  //如果页面存在制指定的字符串
                    feasibleMethods.push(option.methods[i]);
                    resolve();
                }
                console.log(res.text)
                resolve();
            });
        })
    }
    if(siteStatus == undefined){
        return {
            status: '40x',
            msg: '密码可能出错，请确认后，重新提交'
        };
    }else{
        if(feasibleMethods.length > 0){
            return {
                status: '20x',
                msg: '密码验证成功，开始加入到数据库里',
                methods: feasibleMethods
            };
        }else{
            if(siteStatus == ""){
                return {
                    status: '40x',
                    msg: '密码可能出错，请确认后，重新提交'
                };
            }
        }
    }
}

global.addSiteToDatabase = (url,password,methods) => {
    let site = think.model("site",think.config('db'));
    site.addSite({
        url: url,
        password: password,
        methods: methods
    })
    return {
        status: 'success',
        msg: '添加站点成功'
    }
}