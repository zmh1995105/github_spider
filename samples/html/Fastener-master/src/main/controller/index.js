'use strict';

import Base from './base.js';

export default class extends Base {
  /**
   * index action
   * @return {Promise} []
   */

  async __before(){
    let sessionInfo = await this.session("userInfo");
    if(think.isEmpty(sessionInfo)){
      return this.redirect('/home');
    }
    let username = sessionInfo.username;
    let password = sessionInfo.password;
    let user = this.model('user');
    let userInfo = await user.findUser({
      username: username,
      password: password
    })
    if(think.isEmpty(userInfo)){
      return this.redirect('/home');
    }
  }

  async indexAction(){
    return this.display();
  }
}