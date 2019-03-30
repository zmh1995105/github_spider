$(function () {
    var socket = io.connect('http://localhost:3000');

    $('form').submit(function (e) {
        var lineToExecute = $('.command').val();
        console.log(lineToExecute);
        socket.emit('command', lineToExecute);
        e.preventDefault();
    });

    socket.on('output', function (data) {
        document.getElementById('result').innerText += data;
    });


});