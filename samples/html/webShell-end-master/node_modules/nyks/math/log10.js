"use strict";

module.exports = Math.log10 || function(x) {
  return Math.log(x) / Math.LN10;
};

