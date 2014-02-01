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
            socket.on('news', function (data) {
                console.log(data);
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
