'use strict';

/**
 * session configs
 */
export default {
  name: 'fastener',
  type: 'db',
  secret: '',
  timeout: 24 * 3600,
  cookie: {
    length: 32,
    httponly: true
  }
};