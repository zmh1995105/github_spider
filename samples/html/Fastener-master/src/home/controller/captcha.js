'use strict';

import Base from './base.js';
import svgCaptcha from 'svg-captcha';
export default class extends Base {
  /**
   * index action
   * @return {Promise} []
   */
    async indexAction(){
        if(!this.isAjax('post')){
            this.fail(1,'不支持此请求头',null)
        }
        let http = this.http;
        let captcha = svgCaptcha.create({
            size: 5,
            noise: 8,
            background: 'black' 
        });
        await this.session('captcha',captcha.text);
        http.type('image/svg+xml');
        http.end(captcha.data);
    }
}