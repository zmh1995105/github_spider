'use strict';
/**
 * model
 */
export default class extends think.model.mongo {
    //初始化
    init(...args){
        super.init(...args);
        this.tablePrefix = 'fastener_';
        this.tableName = 'site';
    }

    //添加站点
    async addSite(data = {}){
        return await this
            .add({
                url: data.url,
                password: data.password,
                methods: data.methods
            })
    }
    async checkSite(data = {}){
        return await this
            .where({
                url: data.url,
                password: data.password
            })
            .find();
    }
}