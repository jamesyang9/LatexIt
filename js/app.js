$(function() {
    var globalData = new Object();

    globalData.texSeq = [];

    // set up dropbox uploads
    var button = Dropbox.createChooseButton({
        linkType: 'direct',
        extensions: ['.png'],
        success: function(files) {
            var img = files[0].link;
            $.post('upload.php', {file: img}, function(data) {
                console.log(data);
                // todo: things here
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
        var length = $('#ellipsis').html().length;
        var str = '';
        for (var i = 0; i < ((length + 1) % 4); i++) str += '.';
        $('#ellipsis').html(str);
    }, 500);

    // set up play button
    $('#playbtn').click(function() {
        $('#playbtn img, #description').hide();
        $('#waiting').show();
        
        var socket = io.connect('http://localhost:8000');
        socket.emit('info', {'id': USER_ID, 'name': USER_NAME});
        var timer;
        socket.on('start', function(data) {
            $('#playbtn').fadeOut(function() {
                $('#guesser').fadeIn();            

                console.log('got start signal');
                $('#input textarea').attr('disabled', false);
                $('#output').html('');
                $('#sample img').attr('src', 'images/latex/' + data.hw + '_' + data.piece + '.png');
                $('#timer').html('0:30');
                $('#timer').data('time', 30)
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

        $('#input textarea').keydown(function(e) {
            if (e.which == 13) {
                socket.emit('answer', $(this).val());
                $(this).val('');
                $(this).attr('placeholder', '');
                $(this).attr('disabled', true);
                clearInterval(timer);
            }
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

    function isComplete() {
        for(var i = 0; i < $('.hwline').length; i++) {
            if (!globalData.texSeq[i]) {
                return false;
            }
        }
        return true;
    }

    $('#generatePDF').click(function () {
        if(!isComplete()) {
            alert('Please make a choice for every line');
        };
        $.post('algo/generatePDF.php', {'arr': globalData.texSeq, 'id': 54})
        .done(function () {
            window.open("algo/54.pdf");
        });
    });
});
