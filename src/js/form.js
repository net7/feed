function feedBuildUrl() {
    var w = window.location,
        baseURL = w.protocol +'//'+ w.hostname + "/?",
        single = $('#inputurl').val(),
        image = $('#inputimage').val(),
        left = $('#inputLurl').val(),
        right = $('#inputRurl').val(),
        conf = $('#punditConf').val(),
        url;

    $(".control-group.errors-container").empty();

    // Single/image/left not empty, but not an URL: error
    if (single !== '' && !isURL(single))
        url = '';
    else if (image !== '' || !isURL(image))
        url = '';
    else if (left !== '' && !isURL(left))
        url = ''
    else if (single !== '' && isURL(single))
        url = baseURL + "url=" + single;
    else if (image !== '' && isURL(image))
        url = baseURL + "img=" + image;
    else if (isURL(left) && isURL(right))
        url = baseURL +"lurl="+ left +"&rurl="+ right;
        
    if (url !== '')
        url += "&conf="+ conf;
        
    $('#feedThePundit').val(url);
}

function showFeedError(t, d) {
    $("#feedErrorTemplate")
        .tmpl([{title: t, description: d}])
        .appendTo(".control-group.errors-container");
}

function isURL(u) {
    var urlregex = new RegExp("^(http|https|ftp)\://[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(:[a-zA-Z0-9]*)?/.*$");
    return urlregex.test(u);
}

function checkInputURL() {
    var v = $(this).val();
    if (isURL(v) || v === '') 
        feedBuildUrl();
}

(function($){
        
    $('#inputurl')
        .on('focusin focusout', function(event) { feedBuildUrl(); })
        .on('change', checkInputURL);
    $('#inputimage')
        .on('focusin focusout', function(event) { feedBuildUrl(); })
        .on('change', checkInputURL);
    $('#inputLurl')
        .on('focusin focusout', function(event) { feedBuildUrl(); })
        .on('change', checkInputURL);
    $('#inputRurl')
        .on('focusin focusout', function(event) { feedBuildUrl(); })
        .on('change', checkInputURL);
    $('#punditConf').on('change', function(event) { feedBuildUrl(); });

    $('a[data-toggle="tab"]').on('click', function (e) {
        $('#inputurl').val('');
        $('#inputimage').val('');
        $('#inputRurl').val('');
        $('#inputLurl').val('');
    });

    $('form').submit(function() {
        var single = $('#inputurl').val(),
            image = $('#inputimage').val(),
            left = $('#inputLurl').val(),
            right = $('#inputRurl').val(),
            conf = $('#punditConf').val(),
            url = $('#feedThePundit').val();

        $(".control-group.errors-container").empty()

        // ERROR: left/single/image is mandatory
        if (left === '' && single === '' && image === '') {
            console.log('Error: no single/left/image URL');
            showFeedError("Error!", "You must insert at least a source URL or an image URL");
            return false;
        }

        if (single !== '' && !isURL(single)) {
            console.log('Error: invalid URL');
            showFeedError("Error!", "The URL you entered ("+single+") does not look valid.");
            return false;
        }
        
        if (left !== '' && !isURL(left)) {
            console.log('Error: invalid first URL');
            showFeedError("Error!", "The first URL you entered ("+left+") does not look valid.");
            return false;
        }

        if (right !== '' && !isURL(right)) {
            console.log('Error: invalid second URL');
            showFeedError("Error!", "The second URL you entered ("+right+") does not look valid.");
            return false;
        }

        if (image !== '' && !isURL(image)) {
            console.log('Error: invalid image URL');
            showFeedError("Error!", "The image URL you entered ("+image+") does not look valid.");
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
