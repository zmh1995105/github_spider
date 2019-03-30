'use strict';
/**
 * logic
 * @param  {} []
 * @return {}     []
 */
export default class extends think.logic.base {
  /**
   * index action logic
   * @return {} []
   */
  async indexAction(){
    if(!this.isAjax('post')){
      this.fail(1,'不支持此请求头',null)
    }
    let {
      username,
      password,
      captcha
    } = this.post();
    let captchaText = await this.session('captcha');
    if(think.isEmpty(captcha)){
      this.fail(1,"验证码为空","captcha");
    }
    if(captcha.toLowerCase() != captchaText.toLowerCase()){
      await this.session('captcha','');
      this.fail(1,"验证码错误","captcha");
    }
    if(think.isEmpty(username)){
      this.fail(1,"用户名为空","username");
    }
    if(think.isEmpty(password)){
      this.fail(1,"密码为空","password");
    }
    if(regex.specialString.test(username)){
      this.fail(1,"用户名违规","username");
    }
  }
}