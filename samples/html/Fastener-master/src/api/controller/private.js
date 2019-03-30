'use strict';

export default class extends think.controller.base {
    
    async addsiteAction(self){
        let socket = self.http.socket;
        let data = self.http.data;
        let site = this.model("site");
        let siteCheck = await site.checkSite({  //验证数据库里是否已经存在此站点信息
            url: data.site_url,
            password: data.site_password
        })
        if(!think.isEmpty(siteCheck)){
            this.emit("addsite callback",{  //使用socket把信息发送给前端
                status: "50x",
                msg: "数据库里已经存在相同的站点信息，请勿重复添加"
            });
            return false;
        }
        let siteStatus = await checkSite(data.site_url);    //开始进行测试站点的状态码是否为200
        this.emit("addsite callback",{  //使用socket把信息发送给前端
            status: siteStatus.status,
            msg: siteStatus.msg
        });
        if(siteStatus.status !== '20x'){    //如果不是200状态码，将不向下执行
            return false;
        }
        let checkSitePasswordInfo = await checkSitePassword(data.site_url,data.site_password);  //开始验证密码是否正确
        this.emit("addsite callback",{
            status: checkSitePasswordInfo.status,
            msg: checkSitePasswordInfo.msg
        });
        if(checkSitePasswordInfo.status != '20x'){
            return false;
        }
        let addSiteToDatabaseInfo = await addSiteToDatabase(data.site_url,data.site_password,checkSitePasswordInfo.methods);    //开始把数据添加到数据里
        this.emit("addsite callback",{
            status: 'success',
            msg: '添加站点成功'
        });
    }
}