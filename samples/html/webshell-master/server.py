# coding: utf-8

import commands

from flask import Flask, render_template, abort
from flask_socketio import SocketIO, emit

app = Flask(__name__, static_folder='static')

socket = SocketIO(app)

cmd_dict = {
    'tinyproxy start': 'service tinyproxy start',
    'tinyproxy stop': 'service tinyproxy stop',
    'tinyproxy status': 'service tinyproxy status'
}


@app.route('/')
def p500():
    abort(500)


@app.route('/exec/<key>')
def index(key):
    if key != 'zhangyuweiexec':
        abort(500)

    return render_template('index.html')


@socket.on('connect', namespace='/server')
def socket_server():
    emit('connect_success', {'status': '200', 'msg': 'Enter the Los Angeles server'})


@socket.on('exec', namespace='/server')
def socket_server(data):
    cmd_id = data.get('cmd_id', '')
    print cmd_id
    cmd = cmd_dict.get(cmd_id)
    if cmd:
        status, output = commands.getstatusoutput(cmd)
        print output
        emit('exec_output', {'output': output})


@socket.on('exec_cmd', namespace='/server')
def socket_server(data):
    cmd = data.get('cmd', '')
    if cmd:
        status, output = commands.getstatusoutput(cmd)
        print output
        emit('exec_output', {'output': output})


if __name__ == '__main__':
    socket.run(app, port=8000, debug=False)
