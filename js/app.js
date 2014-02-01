$(function() {

    var $container = $('body > .container');
    $('body > .container').css('min-height', window.innerHeight - $container.offset().top);

    var globalData = new Object();

    globalData.texSeq = [];

    if($("#noFiles").length) {
        $(".rhalf").show();
    }
    
    // set up dropbox uploads
    var button = Dropbox.createChooseButton({
        linkType: 'direct',
        extensions: ['.png'],
        success: function(files) {
            var img = files[0].link;
            $.post('upload.php', {file: img}, function(data) {
                console.log(data);
                //window.location.reload();
            });
        }
    });
    $('#upload').append(button);

    // enable latex on page
    MathJax.Hub.Config({
        tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
    });

    // re-typeset on every keystroke
    $('#input textarea').keyup(function() {
        $('#output').html($(this).val());
        MathJax.Hub.Queue(["Typeset",MathJax.Hub]);
    });

    setInterval(function() {
        if ($('#ellipsis').length) {
            var length = $('#ellipsis').html().length;
            var str = '';
            for (var i = 0; i < ((length + 1) % 4); i++) str += '.';
            $('#ellipsis').html(str);
        }
    }, 500);

    // set up play button
    $('#playbtn').click(function() {
        $('#playbtn img, #description').hide();
        $('#waiting').show();
        
        var socket = io.connect('http://' + document.location.hostname + ':8000');
        socket.emit('info', {'id': USER_ID, 'name': USER_NAME});
        var timer;
        socket.on('start', function(data) {
            $('#playbtn, #scoreboard, #tops, #scoreflash').fadeOut(function() {
                $('#guesser').fadeIn();            

                console.log('got start signal');
                $('#input textarea').attr('disabled', false).removeClass('disabled').val('').focus();
                $('#output').html('');
                $('#sample img').attr('src', 'images/latex/' + data.hw + '_' + data.piece + '.png');
                $('#timer').html('0:30');
                $('#timer').data('time', 30)
                clearInterval(timer);
                timer = setInterval(function() { 
                    var time = $('#timer').data('time') - 1;
                    $('#timer').data('time', time);
                    $('#timer').html('0:' + time);
                    
                    if (time == 0) { 
                        clearInterval(timer);
                        socket.emit('answer', $('#input textarea').val());
                    }
                }, 1000);
            });
        });

        socket.on('finished', function(scoreboard) {
            //$('#guesser').fadeOut(function() {
                /*$('#scoreboard').fadeIn();
                $('#scores').html('');
                scoreboard.forEach(function(score) {
                    $('#scores').append('<li>' + score.name + ': ' + score.score + '</li>');
                });*/

                var myScore = 0;
                scoreboard.forEach(function(score) {
                    if (score.id == USER_ID) {
                        myScore = score.score;
                    }
                });

                $('#scoreflash').html('+' + myScore);
                $('#scoreflash').fadeIn(300).delay(1200).fadeOut(300);
            //});
        });

        socket.on('nodata', function() {
            console.log('fail');
        });
        
        $('#input textarea').keydown(function(e) {
            if (e.which == 13) {
                socket.emit('answer', $(this).val());
                $(this).val('Submitted, waiting for other players...');
                $(this).attr('placeholder', '');
                $(this).attr('disabled', true).addClass('disabled');
                clearInterval(timer);
            }
        });

        $(window).unload(function(){
            socket.emit('quit', '');
        });
    });

    $('.hwline .tex').click(function () {
        var idx = $(this).data('n');
        var text = $(this).data('text');
        console.log(idx);
        globalData.texSeq[idx] = text;
        console.log(globalData);
        $('#preview div:nth-child('+(idx+1)+')').html(text);
        $(this).parent().children().removeClass('selected');
        $(this).addClass('selected');
        console.log(isComplete());
        MathJax.Hub.Queue(["Typeset",MathJax.Hub]);
    });

    $('.index #tops').fadeIn();

    function isComplete() {
        for(var i = 0; i < $('.hwline').length; i++) {
            if (!globalData.texSeq[i]) {
                return false;
            }
        }
        return true;
    }

    $('#generatePDF').click(function () {
        var id = 54;
        console.log(globalData.texSeq);
        if(!isComplete()) {
            alert('Please make a choice for every line');
            return;
        };
        $.post('algo/generatePDF.php', {'arr': globalData.texSeq, 'id': id})
        .done(function () {
            window.location.href = "algo/"+id+".pdf";
        });
    });

    $('#generateTEX').click(function () {
        var id = 54;
        console.log(globalData.texSeq);
        if(!isComplete()) {
            alert('Please make a choice for every line');
            return;
        };
        $.post('algo/generateTEX.php', {'arr': globalData.texSeq, 'id': id})
        .done(function () {
           window.location.href = "algo/"+id+".tex";
        });
    });

});
