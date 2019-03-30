'use strict';

var _regenerator = require('babel-runtime/regenerator');

var _regenerator2 = _interopRequireDefault(_regenerator);

var _promise = require('babel-runtime/core-js/promise');

var _promise2 = _interopRequireDefault(_promise);

var _asyncToGenerator2 = require('babel-runtime/helpers/asyncToGenerator');

var _asyncToGenerator3 = _interopRequireDefault(_asyncToGenerator2);

var _superagent = require('superagent');

var _superagent2 = _interopRequireDefault(_superagent);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

/**
 * 判断状态码
 * @author Black-Hole <158blackhole@gmail.com>
 * @description 判断状态码属于哪一种，并返回状态码信息
 * @function
 * @param {string|number} status - 要进行判断的状态码
 * @returns {String} 返回判断后的信息
 */
global.CheckStatusCode = function (status) {
    var StatusCode = status.toString().substring(0, status.toString().length - 1);
    var statusInfo = void 0;
    switch (StatusCode) {
        case '20':
            statusInfo = {
                status: '20x',
                msg: "网页存在，开始验证密码正确性"
            };
            break;
        case '30':
            statusInfo = {
                status: '30x',
                msg: "状态码返回30x，页面可能是重定向，请检查后重试"
            };
            break;
        case '40':
            statusInfo = {
                status: '40x',
                msg: "状态码返回40x，可能是页面可能不存在，请检查后重试"
            };
            break;
        case '41':
            statusInfo = {
                status: '41x',
                msg: "状态码返回41x，可能是服务器验证数据包出现问题，请检查后重试"
            };
            break;
        case '42':
            statusInfo = {
                status: '41x',
                msg: "状态码返回41x，可能是当前资源被锁定，请检查后重试"
            };
            break;
        case '50':
            statusInfo = {
                status: '50x',
                msg: "状态码返回41x，可能是服务器出现错误，请检查后重试"
            };
            break;
        default:
            statusInfo = {
                status: err.status,
                msg: "未知状态码，请检查后重试"
            };
            break;
    }
    return statusInfo;
};

/**
 * 检测站点状态
 * @author Black-Hole <158blackhole@gmail.com>
 * @description 检测站点的状态码是否为200
 * @function
 * @param {string} url - 要进行检测的站点地址
 * @returns {String} 返回检测后的状态
 */
global.checkSite = function () {
    var _ref = (0, _asyncToGenerator3.default)(_regenerator2.default.mark(function _callee(url) {
        return _regenerator2.default.wrap(function _callee$(_context) {
            while (1) {
                switch (_context.prev = _context.next) {
                    case 0:
                        return _context.abrupt('return', new _promise2.default(function (resolve, reject) {
                            _superagent2.default.get(url, function (err, res) {
                                resolve(CheckStatusCode(res.status));
                            });
                        }));

                    case 1:
                    case 'end':
                        return _context.stop();
                }
            }
        }, _callee, undefined);
    }));

    return function (_x) {
        return _ref.apply(this, arguments);
    };
}();

/**
 * 检测站点密码是否正确
 * @author Black-Hole <158blackhole@gmail.com>
 * @description 检测站点的密码是否正确
 * @function
 * @param {string} url - 要进行检测的站点地址
 * @param {string} password - 进行检查的密码
 * @returns {String} 返回检测后的状态
 */
global.checkSitePassword = function () {
    var _ref2 = (0, _asyncToGenerator3.default)(_regenerator2.default.mark(function _callee2(url, password) {
        var siteStatus, feasibleMethods, _loop, i;

        return _regenerator2.default.wrap(function _callee2$(_context3) {
            while (1) {
                switch (_context3.prev = _context3.next) {
                    case 0:
                        siteStatus = void 0, feasibleMethods = [];
                        _loop = _regenerator2.default.mark(function _loop(i) {
                            var sendParams;
                            return _regenerator2.default.wrap(function _loop$(_context2) {
                                while (1) {
                                    switch (_context2.prev = _context2.next) {
                                        case 0:
                                            sendParams = option.methods[i] == 'get' ? 'query' : 'send';
                                            _context2.next = 3;
                                            return new _promise2.default(function (resolve) {
                                                _superagent2.default[option.methods[i]](url)[sendParams](password + "=" + sendCommand.checkPassword) //要发送的验证命令
                                                .end(function (err, res) {
                                                    if (err != null) {
                                                        siteStatus = CheckStatusCode(res.status);
                                                        resolve();
                                                    }
                                                    if (res.text.indexOf(option.onlyString) != -1) {
                                                        //如果页面存在制指定的字符串
                                                        feasibleMethods.push(option.methods[i]);
                                                        resolve();
                                                    }
                                                    console.log(res.text);
                                                    resolve();
                                                });
                                            });

                                        case 3:
                                        case 'end':
                                            return _context2.stop();
                                    }
                                }
                            }, _loop, undefined);
                        });
                        i = 0;

                    case 3:
                        if (!(i < option.methods.length)) {
                            _context3.next = 8;
                            break;
                        }

                        return _context3.delegateYield(_loop(i), 't0', 5);

                    case 5:
                        i++;
                        _context3.next = 3;
                        break;

                    case 8:
                        if (!(siteStatus == undefined)) {
                            _context3.next = 12;
                            break;
                        }

                        return _context3.abrupt('return', {
                            status: '40x',
                            msg: '密码可能出错，请确认后，重新提交'
                        });

                    case 12:
                        if (!(feasibleMethods.length > 0)) {
                            _context3.next = 16;
                            break;
                        }

                        return _context3.abrupt('return', {
                            status: '20x',
                            msg: '密码验证成功，开始加入到数据库里',
                            methods: feasibleMethods
                        });

                    case 16:
                        if (!(siteStatus == "")) {
                            _context3.next = 18;
                            break;
                        }

                        return _context3.abrupt('return', {
                            status: '40x',
                            msg: '密码可能出错，请确认后，重新提交'
                        });

                    case 18:
                    case 'end':
                        return _context3.stop();
                }
            }
        }, _callee2, undefined);
    }));

    return function (_x2, _x3) {
        return _ref2.apply(this, arguments);
    };
}();

global.addSiteToDatabase = function (url, password, methods) {
    var site = think.model("site", think.config('db'));
    site.addSite({
        url: url,
        password: password,
        methods: methods
    });
    return {
        status: 'success',
        msg: '添加站点成功'
    };
};
//# sourceMappingURL=site.js.map