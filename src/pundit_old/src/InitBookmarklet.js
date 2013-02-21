(function() {
    var h = document.getElementsByTagName('head')[0],
        d = document.createElement('script'),
        l = document.createElement('link');

    l.rel = 'stylesheet';
    l.href = 'http://metasound.dibet.univpm.it/release_bot/build-development/css/pundit.css';
    l.type = 'text/css';
    l.media = 'screen';
    l.charset = 'utf-8';
    h.appendChild(l);

    punditConfig = {

        debugAllModules: false,
        vocabularies: [
        ],

        useBasicRelations: true,
    
        modules: {

        }

    };

    djConfig = {
        afterOnLoad: true,
        useXDomain: true,
        baseUrl: "http://metasound.dibet.univpm.it/release_bot/build-development/bookmarklet_build/dojo/",
        require: ["dojo.Bookmarklet"]
    };
    d.type = 'text/javascript';
    d.src = 'http://metasound.dibet.univpm.it/release_bot/build-development/bookmarklet_build/dojo/dojo.xd.js';
    h.appendChild(d);

})();
