var result = {};
result.URL = document.URL;

var s = new XMLSerializer();
var d = document;
result.XML = s.serializeToString(d);

result = result;