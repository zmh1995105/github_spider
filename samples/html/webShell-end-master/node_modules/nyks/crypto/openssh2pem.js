"use strict";

var ASN_LONG_LEN  = 0x80, SSH_RSA = 'ssh-rsa';

function ASN_len(s) {
    var len = s.length;
    if (len < ASN_LONG_LEN)
        return new Buffer([len]);

    var data = len.toString(16);
    if(data.length & 1)
      data = "0" + data;
    data = new Buffer(data, 'hex');
    return Buffer.concat([new Buffer([data.length | ASN_LONG_LEN]), data]);;
}
var unpack = function(mode, data, start){
  if(mode != "L")
      throw "Unsupported mode";
  var slice = data.slice(start, 4);
  var out = (slice[0] << 24) + (slice[1] << 16) + (slice[2] << 8) + slice[3];
  return [out];
}

var asnf = function(type, body){
  return Buffer.concat([new Buffer([type]), ASN_len(body), body]);
}


module.exports = function(openssh_data) {
    if(openssh_data.substr(0, SSH_RSA.length) == SSH_RSA)
      openssh_data = openssh_data.substr(SSH_RSA.length);

    var data = new Buffer(openssh_data, 'base64');

    var alg_len = unpack('L', data, 0)[0];

    var i = 4;
    var alg     = data.slice(i, i += alg_len).toString('ascii');
    if (alg !== 'ssh-rsa')
        throw "Not rsa";

    var e_len = unpack('L', data.slice(i, i += 4))[0];
    var e = data.slice(i, i += e_len);

    var n_len = unpack('L', data.slice(i, i += 4))[0];
    var n = data.slice(i, i += n_len);

    var algid = new Buffer('06092a864886f70d0101010500', 'hex');

    algid = asnf(0x30, algid); // wrap it into sequence
    data  = asnf(0x02, n);     // numbers

    data = Buffer.concat([data, asnf(0x02, e)]);
    data = asnf(0x30, data);    // wrap it into sequence
    data = Buffer.concat([new Buffer([0]),  data]);  // don't know why, but needed
    data = asnf(0x03, data);                  // wrap it into bitstring
    data = Buffer.concat([algid, data]);      // prepend algid
    data = asnf(0x30, data);                  // wrap it into sequence

    return data.toString('base64');
}
