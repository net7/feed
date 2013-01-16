function feedBuildUrl() {
    var baseURL = "/?",
        left = $('#inputLurl').val(),
        right = $('#inputRurl').val(),
        conf = $('#punditConf').val(),
        url;

    if (left === '' && right === '') 
        url = '';
    else if (left !== '' && right === '')
        url = baseURL + "url=" + left + "&conf="+ conf;
    else
        url = baseURL +"lurl="+ left +"&rurl="+ right + "&conf="+ conf;

        
    // TODO: sanity checks on URLs ?

    $('#feedThePundit').val(url);

}



(function($){
    
    $('#inputLurl').on('focusout', function(event) { feedBuildUrl(); });
    $('#inputRurl').on('focusout', function(event) { feedBuildUrl(); });
    $('#punditConf').on('change', function(event) { feedBuildUrl(); });

    $('#inputLurl').get(0).focus();

    $('form').submit(function() {
        var url = $('#feedThePundit').val();
        
        // TODO: sanity check on this created URL ?
        if (url !== '')
            window.location = url;

        return false;
    });

})(jQuery);
