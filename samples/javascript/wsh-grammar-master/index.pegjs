program
  = head:expression rest:( pipe e:expression { return e } )* { return { expressions: [head].concat(rest) } }

// literals

ws "whitespace" = [ \t\n\r]
nl "newline" = "\n" / "\r\n" / "\r" / "\f"
escape "escaped character" = "\\" ch:[^\r\n\f0-9a-f]i { return ch; }
char "character" = [^ \t\n\r\\] / escape
token = chars:([^\n\r\f\\"\\' |] / escape)+ {
  return chars.join('');
}
string1 = '"' chars:([^\n\r\f\\"] / escape)* '"' {
  return chars.join('');
}
string2 = "'" chars:([^\n\r\f\\'] / escape)* "'" {
  return chars.join('');
}
string = string1 / string2
value = token / string
pipe = '|'

// expression parts

/*
Because peg.js doesnt have any backtracking, we need to test before consuming the method
Example input that fails without this: "foo | bar"
*/ 
expression
  = & expression_with_method e:expression_with_method { return e }
  / & expression_without_method e:expression_without_method { return e }
expression_with_method = ws* method:method? url:url params:( ws p:param { return p } )* ws* {
  var obj = { url: url, params: params };
  if (typeof method != 'undefined') { obj.method = method; }
  return obj;
}
expression_without_method = ws* url:url params:( ws p:param { return p } )* ws* {
  var obj = { url: url, params: params };
  if (typeof method != 'undefined') { obj.method = method; }
  return obj;
}
method = m:token ws+ { return m }
url = value
params = ( param )*
param
  = queryparam
  / headerparam
  / qqueryparam
queryparam = '?' key:token value:( ws value )? { return { type: 'query', key: key, value: value[1] } }
headerparam = '--' key:token value:( ws value )? { return { type: 'header', key: key, value: value[1] } }
qqueryparam = value:value { return { type: 'query', key: 'q', value: value }; }