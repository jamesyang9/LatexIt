$(function() {

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

    // set up play button
    $('#playbtn').click(function() {
        $(this).fadeOut(function() {
            $('#guesser').fadeIn();

            var socket = io.connect('http://localhost:8000');
            socket.emit('info', {'id': USER_ID, 'name': USER_NAME});
            var timer;
            socket.on('start', function(data) {
                console.log('got start signal');
                $('#input textarea').attr('disabled', false);
                $('#sample img').attr('src', 'images/latex/' + data.hw + '_' + data.piece + '.png');
                $('#timer').html('0:30');
                $('#timer').data('time', 30)
                timer = setInterval(function() { 
                    var time = $('#timer').data('time') - 1;
                    $('#timer').data('time', time);
                    $('#timer').html('0:' + time);

                    if (time == 0) { 
                        clearInterval(timer);
                        socket.emit('answer', $(this).val());
                    }
                }, 1000);
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
    });

    $('.hwline .tex').click(function () {
        var idx = $(this).data('n');
        var text = $(this).data('text');
        $('#preview div:nth-child('+(idx+1)+')').html(text);
        $(this).parent().children().removeClass('selected');
        $(this).addClass('selected');
    });
});
