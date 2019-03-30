'use strict';

import Base from './base.js';

export default class extends Base {
  async indexAction(){
    let username = this.post('username');
    let password = think.md5(this.post('password'));
    let user = this.model("user");
    let userData = await user.userList();
    if(think.isEmpty(userData)){
        user.addUser({
            username: username,
            password: password
        })
    }else{
        let userInfo = await user.findUser({
            username: username,
            password: password
        });
        if(think.isEmpty(userInfo)){
            this.fail(1,"用户或密码错误","username or password");
        }
    }
    await this.session('userInfo',{
        username: username,
        password: password
    });
    return this.success(0,"登陆成功",null);
  }
}