'use strict';

global.regex = {
    specialString: /[`~!@#$%^&*()+<>?:"{},.\/;'[\]]/i //检测有没有违法字符串
};

global.option = {
    onlyString: 'fastener_TestSitePassWord', //唯一字符串，用于检测命令是否完成
    methods: ['get', 'post'] //支持的模式，后期添加cookies、user-agent等
};

global.sendCommand = {
    checkPassword: 'echo%20"fastener_TestSitePassWord";' //发送检测的命令
};
//# sourceMappingURL=global.js.map