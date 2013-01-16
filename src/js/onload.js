(function($){

    $('*').each(function(i,e) { $(e).attr('style', ''); $(e).attr('width', ''); })
    $("[rel='popover']").popover();
    $("[rel='tooltip']").tooltip();

})(jQuery);
