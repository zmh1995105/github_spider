'use strict';
/**
 * model
 */
export default class extends think.model.mongo {
    //初始化
    init(...args){
        super.init(...args);
        this.tablePrefix = 'fastener_';
        this.tableName = 'user';
    }
    //添加用户
    async addUser(data = {}) {
        return await this
            .add({
                username: data.username,
                password: data.password
            })
    }
    //用户列表
    async userList(){
        return await this.
            select();
    }
    //查找用户
    async findUser(data = {}){
        return await this.
            where({
                username: data.username,
                password: data.password
            })
            .find();
    }
}