// TODO: nice comment explaining where to find info on this file

var punditConfig = {

    debugAllModules: false,

    // annotationServerBaseURL : '',

    vocabularies: [

	'http://metasound.dibet.univpm.it/marinelives/Marinelives-Ships.json',
    'http://metasound.dibet.univpm.it/marinelives/Marinelives-Relations.json'

    ],

    useBasicRelations: false,

    modules: {
        
        'pundit.Help': {
            introductionFile: 'example-introduction.html',
            introductionWindowTitle: 'Welcome to Pundit examples! :)',
            showIntroductionAtLogin: true
        },
        'pundit.NamedContentHandler': {
            active: false
        },
        
        'selectors': {},
        'annotators': {}
    }

};
