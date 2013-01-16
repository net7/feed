function feedBuildUrl() {
    $('#feedThePundit').val('Prova');
}

(function($){
   $('#inputLurl').on('focusout', function(event) {feedBuildUrl()});
   $('#inputRurl').on('focusout', function(event) {feedBuildUrl()});
})(jQuery);
