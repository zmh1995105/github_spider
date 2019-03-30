const tape = require('tape')
const Parser = require('../index')
const fs = require('fs')
const Tracer = require('pegjs-backtrace')

var inputs, outputs
try {
  inputs = fs.readFileSync(__dirname + '/fixture/inputs.txt', 'utf8').split('\n').filter(Boolean)
  outputs = fs.readFileSync(__dirname + '/fixture/outputs.txt', 'utf8').split('\n').filter(Boolean).map(str => JSON.parse(str))
} catch (e) {
  console.log(e)
  process.exit(0)
}

inputs.forEach((input, i) => {
  tape(input, t => {
    var tracer = new Tracer(input)
    try {
      t.deepEqual(Parser.parse(input, { tracer }), outputs[i])
    } catch (e) {
      console.log(tracer.getBacktraceString())
      throw new Error('Failed to parse input')
    }
    t.end()
  })
})
