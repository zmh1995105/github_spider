'use strict';

exports.__esModule = true;

var _regenerator = require("babel-runtime/regenerator");

var _regenerator2 = _interopRequireDefault(_regenerator);

var _asyncToGenerator2 = require("babel-runtime/helpers/asyncToGenerator");

var _asyncToGenerator3 = _interopRequireDefault(_asyncToGenerator2);

var _classCallCheck2 = require("babel-runtime/helpers/classCallCheck");

var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);

var _possibleConstructorReturn2 = require("babel-runtime/helpers/possibleConstructorReturn");

var _possibleConstructorReturn3 = _interopRequireDefault(_possibleConstructorReturn2);

var _inherits2 = require("babel-runtime/helpers/inherits");

var _inherits3 = _interopRequireDefault(_inherits2);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var _class = function (_think$controller$bas) {
    (0, _inherits3.default)(_class, _think$controller$bas);

    function _class() {
        (0, _classCallCheck3.default)(this, _class);
        return (0, _possibleConstructorReturn3.default)(this, _think$controller$bas.apply(this, arguments));
    }

    _class.prototype.addsiteAction = function () {
        var _ref = (0, _asyncToGenerator3.default)(_regenerator2.default.mark(function _callee(self) {
            var socket, data, site, siteCheck, siteStatus, checkSitePasswordInfo, addSiteToDatabaseInfo;
            return _regenerator2.default.wrap(function _callee$(_context) {
                while (1) {
                    switch (_context.prev = _context.next) {
                        case 0:
                            socket = self.http.socket;
                            data = self.http.data;
                            site = this.model("site");
                            _context.next = 5;
                            return site.checkSite({ //验证数据库里是否已经存在此站点信息
                                url: data.site_url,
                                password: data.site_password
                            });

                        case 5:
                            siteCheck = _context.sent;

                            if (think.isEmpty(siteCheck)) {
                                _context.next = 9;
                                break;
                            }

                            this.emit("addsite callback", { //使用socket把信息发送给前端
                                status: "50x",
                                msg: "数据库里已经存在相同的站点信息，请勿重复添加"
                            });
                            return _context.abrupt("return", false);

                        case 9:
                            _context.next = 11;
                            return checkSite(data.site_url);

                        case 11:
                            siteStatus = _context.sent;
                            //开始进行测试站点的状态码是否为200
                            this.emit("addsite callback", { //使用socket把信息发送给前端
                                status: siteStatus.status,
                                msg: siteStatus.msg
                            });

                            if (!(siteStatus.status !== '20x')) {
                                _context.next = 15;
                                break;
                            }

                            return _context.abrupt("return", false);

                        case 15:
                            _context.next = 17;
                            return checkSitePassword(data.site_url, data.site_password);

                        case 17:
                            checkSitePasswordInfo = _context.sent;
                            //开始验证密码是否正确
                            this.emit("addsite callback", {
                                status: checkSitePasswordInfo.status,
                                msg: checkSitePasswordInfo.msg
                            });

                            if (!(checkSitePasswordInfo.status != '20x')) {
                                _context.next = 21;
                                break;
                            }

                            return _context.abrupt("return", false);

                        case 21:
                            _context.next = 23;
                            return addSiteToDatabase(data.site_url, data.site_password, checkSitePasswordInfo.methods);

                        case 23:
                            addSiteToDatabaseInfo = _context.sent;
                            //开始把数据添加到数据里
                            this.emit("addsite callback", {
                                status: 'success',
                                msg: '添加站点成功'
                            });

                        case 25:
                        case "end":
                            return _context.stop();
                    }
                }
            }, _callee, this);
        }));

        function addsiteAction(_x) {
            return _ref.apply(this, arguments);
        }

        return addsiteAction;
    }();

    return _class;
}(think.controller.base);

exports.default = _class;
//# sourceMappingURL=private.js.map