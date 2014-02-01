var io = require('socket.io').listen(8000);
var RWL = require('rwlock');
var exec = require('child_process').exec;
var sqlite3 = require('sqlite3').verbose();
var temp = require('temp');
var fs = require('fs');
var db = new sqlite3.Database('db/site.db');

var rooms = [];
var users = [];

temp.track();

function active(room) {
    return room.users.length >= 3;
}

var lock = new RWL();
function assign(user) {
    var room;

    lock.writeLock(function(release) {
        for (var i = 0; i < rooms.length; i++) {
            room = rooms[i];
            if (!room.running && !active(room)) {
                room.users.push(user);
                user.room = room;
                console.log('Adding ' + user.user_name + ' to room');
                
                if (active(room)) {
                    start(room);
                }

                release();
                return;
            }
        }

        db.all("SELECT * FROM homeworks", function(err, hws) {
            db.all("SELECT * FROM answers", function(err, answers) {
                for (var h = 0; h < hws.length; h++) {
                    var hw = hws[h];
                    
                    var pieces = [];
                    for (var i = 0; i < hw.num_pieces; i++) {
                        pieces.push(i);
                    }
                    
                    answers.forEach(function(answer) {
                        if (answer.hw_id != hw.id) return;

                        var idx = pieces.indexOf(answer.piece_num);
                        if (idx > -1) {
                            pieces.splice(idx, 1);
                        }
                    });

                    if (pieces.length === 0) continue;
                    
                    hw_id = hw.id;
                    piece_num = pieces[Math.floor(Math.random() * pieces.length)];
                    
                    room = {users: [user], 
                            time: new Date().getTime(), 
                            running: false,
                            hw: hw_id,
                            piece: piece_num,
                            answers: 0};
                    rooms.push(room);
                    
                    console.log('Creating new room', room);
                    
                    user.room = room;
                    release();
                    return;
                }

                user.emit('nodata', '');
                release();
            });
        });
    });
}

function start(room) {
    console.log('Starting new room...');
    room.running = true;
    var room_new = {hw: room.hw, piece: room.piece, users: []};
    room.users.forEach(function(user) { 
        room_new.users.push(user.user_name); 
    });
    room.users.forEach(function(user) {
        user.emit('start', room_new);
    });
}

io.sockets.on('connection', function (socket) {
    socket.on('info', function(info) {
        socket.user_id = info.id;
        socket.user_name = info.name;
        users[info.id] = socket;

        assign(socket);
    });

    socket.on('quit', function() {
        if (socket.room) {
            for (var i = 0; i < socket.room.users.length; i++) {
                if (socket.room.users[i].user_id == socket.user_id) {
                    console.log(socket.user_name + ' is a quitter');
                    socket.room.users.splice(i, 1);
                    break;
                }
            }
            
            if (socket.room.users.length == socket.room.answers) {
                finish('');
            }
        }
    });

    function finish(text) {
        console.log('Room finished');
        var times = [];
        socket.room.users.forEach(function(user) {
            times.push(user);
        });

        times.sort(function(a, b) {
            return a.answer_time < b.answer_time;
        });

        var scoreboard = [];
        var just_text = times.map(function(u){ return u.text; });

        temp.open('latex', function(err, info) {
            fs.write(info.fd, just_text.join("\n"));
            fs.close(info.fd, function(err) {
                console.log('Execing', "php algo/score.php " + info.path + " " + times.length);
                exec("php algo/score.php " + info.path + " " + times.length, function(error, stdout, stderr) {
                    var scores = JSON.parse(stdout);
                    
                    for (var i = 0; i < times.length; i++) {
                        var score = scores[i];
                        var stmt = db.prepare('UPDATE answers SET score = ? WHERE answerer_id = ? AND hw_id = ?');
                        stmt.run(score, socket.user_id, socket.room.hw);
                        scoreboard.push({id:times[i].user_id, name:times[i].user_name, score: score});
                    }
                    stmt.finalize()
                    
                    socket.room.users.forEach(function(user) {
                        user.emit('finished', scoreboard);
                        setTimeout(function() {
                            user.room = null;
                            console.log(user.user_name + ' getting reassigned');
                            assign(user);
                        }, 2000);
                    });
                });
                
            });
        });

    }

    socket.on('answer', function(text) {
        if (text.trim() !== '') {
            var stmt = db.prepare('INSERT INTO answers (hw_id, answerer_id, answer, piece_num) VALUES(?, ?, ?, ?)');
            stmt.run(socket.room.hw, socket.user_id, text, socket.room.piece);
            stmt.finalize();
        }

        socket.answer_time = new Date().getTime() - socket.room.time;
        socket.text = text;

        socket.room.answers++;
        if (socket.room.answers == socket.room.users.length) {
            finish(text);
        }
    });
});
