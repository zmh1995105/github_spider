'use strict';

exports.__esModule = true;

var _regenerator = require('babel-runtime/regenerator');

var _regenerator2 = _interopRequireDefault(_regenerator);

var _asyncToGenerator2 = require('babel-runtime/helpers/asyncToGenerator');

var _asyncToGenerator3 = _interopRequireDefault(_asyncToGenerator2);

var _classCallCheck2 = require('babel-runtime/helpers/classCallCheck');

var _classCallCheck3 = _interopRequireDefault(_classCallCheck2);

var _possibleConstructorReturn2 = require('babel-runtime/helpers/possibleConstructorReturn');

var _possibleConstructorReturn3 = _interopRequireDefault(_possibleConstructorReturn2);

var _inherits2 = require('babel-runtime/helpers/inherits');

var _inherits3 = _interopRequireDefault(_inherits2);

var _base = require('./base.js');

var _base2 = _interopRequireDefault(_base);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var _class = function (_Base) {
    (0, _inherits3.default)(_class, _Base);

    function _class() {
        (0, _classCallCheck3.default)(this, _class);
        return (0, _possibleConstructorReturn3.default)(this, _Base.apply(this, arguments));
    }

    _class.prototype.indexAction = function () {
        var _ref = (0, _asyncToGenerator3.default)(_regenerator2.default.mark(function _callee() {
            var username, password, user, userData, userInfo;
            return _regenerator2.default.wrap(function _callee$(_context) {
                while (1) {
                    switch (_context.prev = _context.next) {
                        case 0:
                            username = this.post('username');
                            password = think.md5(this.post('password'));
                            user = this.model("user");
                            _context.next = 5;
                            return user.userList();

                        case 5:
                            userData = _context.sent;

                            if (!think.isEmpty(userData)) {
                                _context.next = 10;
                                break;
                            }

                            user.addUser({
                                username: username,
                                password: password
                            });
                            _context.next = 14;
                            break;

                        case 10:
                            _context.next = 12;
                            return user.findUser({
                                username: username,
                                password: password
                            });

                        case 12:
                            userInfo = _context.sent;

                            if (think.isEmpty(userInfo)) {
                                this.fail(1, "用户或密码错误", "username or password");
                            }

                        case 14:
                            _context.next = 16;
                            return this.session('userInfo', {
                                username: username,
                                password: password
                            });

                        case 16:
                            return _context.abrupt('return', this.success(0, "登陆成功", null));

                        case 17:
                        case 'end':
                            return _context.stop();
                    }
                }
            }, _callee, this);
        }));

        function indexAction() {
            return _ref.apply(this, arguments);
        }

        return indexAction;
    }();

    return _class;
}(_base2.default);

exports.default = _class;
//# sourceMappingURL=login_check.js.map