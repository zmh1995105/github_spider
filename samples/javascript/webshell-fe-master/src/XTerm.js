import React, {Component} from 'react'
import {Terminal} from 'xterm'
import * as fullscreen from 'xterm/lib/addons/fullscreen/fullscreen'
import * as attach from 'xterm/lib/addons/attach/attach'
import * as fit from 'xterm/lib/addons/fit/fit'
import 'xterm/dist/xterm.css'
import 'xterm/lib/addons/fullscreen/fullscreen.css'
import io from 'socket.io-client'

export default class XTerm extends Component {
  refTerminal = React.createRef()
  terminal = undefined
  websocket = undefined
  componentDidMount() {
    this.initTermial()
    this.initSocket()
  }
  
  initTermial() {
    Terminal.applyAddon(fullscreen)
    Terminal.applyAddon(fit)
    Terminal.applyAddon(attach)
    this.termial = new Terminal({
      useStyle: true,
      convertEol: true,
      screenKeys: true,
      cursorBlink: true,
      visualBell: true
    })
    this.termial.open(this.refTerminal.current)
    this.termial.toggleFullScreen(true)
    this.termial.fit()
  }

  initSocket() {
    const {match: {params:{containerId}}} = this.props
    this.websocket = io(`http://localhost:3003`)
    // this.websocket.addEventListener('open', event => {
    //   this.websocket.send('message', 'Hello Server.')
    //   console.log('Connection established.', event)
    // })
    // this.websocket.addEventListener('message', event => {
    //   console.log('Receive message.', event)
    // })
    // this.termial.attach(this.websocket)
  }

  render() {
    // const {match} = this.props
    return (
      <div ref={this.refTerminal}>
        {/* shell {match.params.containerId} */}
      </div>
    )
  }
}
