'use strict';
/**
 * model
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

var _class = function (_think$model$mongo) {
    (0, _inherits3.default)(_class, _think$model$mongo);

    function _class() {
        (0, _classCallCheck3.default)(this, _class);
        return (0, _possibleConstructorReturn3.default)(this, _think$model$mongo.apply(this, arguments));
    }

    //初始化
    _class.prototype.init = function init() {
        var _think$model$mongo$pr;

        for (var _len = arguments.length, args = Array(_len), _key = 0; _key < _len; _key++) {
            args[_key] = arguments[_key];
        }

        (_think$model$mongo$pr = _think$model$mongo.prototype.init).call.apply(_think$model$mongo$pr, [this].concat(args));
        this.tablePrefix = 'fastener_';
        this.tableName = 'site';
    };

    //添加站点


    _class.prototype.addSite = function () {
        var _ref = (0, _asyncToGenerator3.default)(_regenerator2.default.mark(function _callee() {
            var data = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
            return _regenerator2.default.wrap(function _callee$(_context) {
                while (1) {
                    switch (_context.prev = _context.next) {
                        case 0:
                            _context.next = 2;
                            return this.add({
                                url: data.url,
                                password: data.password,
                                methods: data.methods
                            });

                        case 2:
                            return _context.abrupt('return', _context.sent);

                        case 3:
                        case 'end':
                            return _context.stop();
                    }
                }
            }, _callee, this);
        }));

        function addSite() {
            return _ref.apply(this, arguments);
        }

        return addSite;
    }();

    _class.prototype.checkSite = function () {
        var _ref2 = (0, _asyncToGenerator3.default)(_regenerator2.default.mark(function _callee2() {
            var data = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
            return _regenerator2.default.wrap(function _callee2$(_context2) {
                while (1) {
                    switch (_context2.prev = _context2.next) {
                        case 0:
                            _context2.next = 2;
                            return this.where({
                                url: data.url,
                                password: data.password
                            }).find();

                        case 2:
                            return _context2.abrupt('return', _context2.sent);

                        case 3:
                        case 'end':
                            return _context2.stop();
                    }
                }
            }, _callee2, this);
        }));

        function checkSite() {
            return _ref2.apply(this, arguments);
        }

        return checkSite;
    }();

    return _class;
}(think.model.mongo);

exports.default = _class;
//# sourceMappingURL=site.js.map