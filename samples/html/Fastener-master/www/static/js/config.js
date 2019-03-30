'use strict';

var configOption = {
    scriptFile: ['PHP','ASP','JSP'],
}

var regex = {
    specialString: /[`~!@#$%^&*()+<>?:"{},.\/;'[\]]/i,
    checkUrl: /((http|ftp|https):\/\/)(([a-zA-Z0-9\._-]+\.[a-zA-Z]{2,6})|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,4})*(\/[a-zA-Z0-9\&#+%_\./-~-]*)?/,
    
}

var fun = {
    /**
     * 截取字符串
     * @author Black-Hole <158blackhole@gmail.com>
     * @description 超出部分以“...”代替
     * @function
     * @param {string|object} text - 要进行检测的字符串
     * @param {int} len - 判断字符串是否大于这个长度，如果大于则进行截取
     * @returns {String} 返回被截取的字符串
     */
    curStr: (text,len) => {
        if(text instanceof jQuery){ //如果是jQuery对象时
            return text.text().length > len ? text.text().substr(0,len) + '...': text.text();
        }else if(typeof text == 'string' && text.constructor == String){    //如果是字符串时
            return text.length > len ? text.substr(0,len) + '...' : text;
        }else{  //如果是原生javascript对象时
            return text.innerHTML.length > len ? text.innerHTML.substr(0,len) + '...' : text.innerHTM;
        }
    },
    parseUrl: (url) => {
        var a =  document.createElement('a');
        a.href = url;
        return {
            source: url,
            protocol: a.protocol.replace(':',''),
            host: a.hostname,
            port: a.port,
            query: a.search,
            params: (function(){
                var ret = {},
                    seg = a.search.replace(/^\?/,'').split('&'),
                    len = seg.length, i = 0, s;
                for (;i<len;i++) {
                    if (!seg[i]) { continue; }
                    s = seg[i].split('=');
                    ret[s[0]] = s[1];
                }
                return ret;
            })(),   
            file: (a.pathname.match(/\/([^\/?#]+)$/i) || [,''])[1],
            hash: a.hash.replace('#',''),
            path: a.pathname.replace(/^([^\/])/,'/$1'),
            relative: (a.href.match(/tps?:\/\/[^\/]+(.+)/) || [,''])[1],
            segments: a.pathname.replace(/^\//,'').split('/')
        }
    }
}