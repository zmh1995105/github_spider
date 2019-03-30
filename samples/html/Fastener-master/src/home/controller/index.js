'use strict';

import Base from './base.js';
import svgCaptcha from 'svg-captcha';

export default class extends Base {
  /**
   * index action
   * @return {Promise} []
   */
  indexAction(){
    return this.display();
  }
}