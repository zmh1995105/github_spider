'use strict';

const clipboard = require('electron').clipboard;

class Plugin {

  constructor(opt) {
    clipboard.writeText(JSON.stringify(opt));
    // 检测是否复制成功
    let txt = clipboard.readText();
    if (txt.indexOf(opt["url"])>0) {
      toastr.success('复制成功！', 'Success');
    }else{
      toastr.error('复制失败！', 'Error');
    }
  }
}

module.exports = Plugin;
