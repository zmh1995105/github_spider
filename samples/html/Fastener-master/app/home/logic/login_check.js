'use strict';
/**
 * logic
 * @param  {} []
 * @return {}     []
 */

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

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

var _class = function (_think$logic$base) {
  (0, _inherits3.default)(_class, _think$logic$base);

  function _class() {
    (0, _classCallCheck3.default)(this, _class);
    return (0, _possibleConstructorReturn3.default)(this, _think$logic$base.apply(this, arguments));
  }

  /**
   * index action logic
   * @return {} []
   */
  _class.prototype.indexAction = function () {
    var _ref = (0, _asyncToGenerator3.default)(_regenerator2.default.mark(function _callee() {
      var _post, username, password, captcha, captchaText;

      return _regenerator2.default.wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              if (!this.isAjax('post')) {
                this.fail(1, '不支持此请求头', null);
              }
              _post = this.post(), username = _post.username, password = _post.password, captcha = _post.captcha;
              _context.next = 4;
              return this.session('captcha');

            case 4:
              captchaText = _context.sent;

              if (think.isEmpty(captcha)) {
                this.fail(1, "验证码为空", "captcha");
              }

              if (!(captcha.toLowerCase() != captchaText.toLowerCase())) {
                _context.next = 10;
                break;
              }

              _context.next = 9;
              return this.session('captcha', '');

            case 9:
              this.fail(1, "验证码错误", "captcha");

            case 10:
              if (think.isEmpty(username)) {
                this.fail(1, "用户名为空", "username");
              }
              if (think.isEmpty(password)) {
                this.fail(1, "密码为空", "password");
              }
              if (regex.specialString.test(username)) {
                this.fail(1, "用户名违规", "username");
              }

            case 13:
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
}(think.logic.base);

exports.default = _class;
//# sourceMappingURL=login_check.js.map