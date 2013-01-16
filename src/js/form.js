function feedBuildUrl() {
    var left = $('#inputLurl').val(),
        right = $('#inputRurl').val();
        url = "/?lurl="+ left +"&rurl="+ right;

    if (left === '' || right === '')
        return false;
        
    // TODO: sanity checks on URLs ?

    $('#feedThePundit').val(url);

}



(function($){
    
    $('#inputLurl').on('focusout', function(event) { feedBuildUrl(); });
    $('#inputRurl').on('focusout', function(event) { feedBuildUrl(); });

    $('#inputLurl').get(0).focus();

    $('form').submit(function() {
        var url = $('#feedThePundit').val();
        
        // TODO: sanity check on this created URL ?
        if (url !== '')
            window.location = url;

        return false;
    });

})(jQuery);
