$(function() {
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
});
