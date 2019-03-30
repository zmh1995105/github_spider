# Wsh-Grammar

```js
const parser = require('wsh-grammar')
parser.parse('get foo ?a b | post bar "c d"') /* => {
  expressions: [
    { method: 'get', url: 'foo', params: { type: 'query', key: 'a', value: 'b' } },
    { method: 'post', url: 'bar', params: { type: 'query', key: 'q', value: 'c d' } }
  ]
}*/
```

- **To build the parser**: `npm run build`
- **To build the fixtures**: `npm run build-fixtures` 
- **To test**: `npm test`