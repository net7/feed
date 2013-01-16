function feedBuildUrl() {
    var baseURL = "/?",
        left = $('#inputLurl').val(),
        right = $('#inputRurl').val(),
        conf = $('#punditConf').val(),
        url;

    $(".control-group.errors-container").empty()

    if (left === '') 
        url = '';
    else if (left !== '' && right === '')
        url = baseURL + "url=" + left + "&conf="+ conf;
    else
        url = baseURL +"lurl="+ left +"&rurl="+ right + "&conf="+ conf;
        
    $('#feedThePundit').val(url);
}

function showFeedError(t, d) {
    $("#feedErrorTemplate")
        .tmpl([{title: t, description: d}])
        .appendTo(".control-group.errors-container");
}


(function($){
    
    // TODO : better handle the various events the users can do.. like select from
    // the autocomplete
    $('#inputLurl').on('focusin', function(event) { feedBuildUrl(); });
    $('#inputLurl').on('focusout', function(event) { feedBuildUrl(); });
    $('#inputRurl').on('focusin', function(event) { feedBuildUrl(); });
    $('#inputRurl').on('focusout', function(event) { feedBuildUrl(); });
    $('#punditConf').on('change', function(event) { feedBuildUrl(); });

    $('#inputLurl').get(0).focus();

    $('form').submit(function() {
        var left = $('#inputLurl').val(),
            right = $('#inputRurl').val(),
            conf = $('#punditConf').val(),
            url = $('#feedThePundit').val();
            urlregex = new RegExp("^(http|https|ftp)\://[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(:[a-zA-Z0-9]*)?/.*$");

        $(".control-group.errors-container").empty()

        // ERROR: left url is mandatory
        if (left === '') {
            console.log('Error: no left URL');
            showFeedError("Error!", "You must insert at least the first source URL");
            return false;
        }
        
        if (!urlregex.test(left)) {
            console.log('Error: invalid first URL');
            showFeedError("Error!", "The first URL you entered ("+left+") does not look valid.");
            return false;
        }

        if (right !== '' && !urlregex.test(right)) {
            console.log('Error: invalid second URL');
            showFeedError("Error!", "The second URL you entered ("+right+") does not look valid.");
            return false;
        }
        
        // TODO: sanity check on this created URL ?
        
        var bu = $('#feedSubmitButton'),
            te = bu.attr('data-loading-text') || "Loading Pundit";
        
        bu.html(te);
        bu.attr('disabled', 'disabled');
        
        if (url !== '')
            window.location = url;

        return false;
    });

})(jQuery);
