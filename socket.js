var io = require('socket.io').listen(8000);
var sqlite3 = require('sqlite3').verbose();
var db = new sqlite3.Database('site.db');

var rooms =[];

io.sockets.on('connection', function (socket) {
    
});
