'use strict';
/**
 * db config
 * @type {Object}
 */
export default {
  type: 'mongo',
  log_sql: true,
  log_connect: true,
  adapter: {
    mongo:{
      host: '127.0.0.1',
      port: '27017',
      database: 'fastener',
      prefix: 'fastener_',
      encoding: 'utf8'
    }
  }
};