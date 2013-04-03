var punditConfig = {
    debugAllModules: false,
    annotationServerBaseURL: "http://as.thepund.it:8080/annotationserver/",
    vocabularies: [
       'http://metasound.dibet.univpm.it/release_bot/build/examples/vocabs/daphnetModern.jsonp',
       'http://metasound.dibet.univpm.it/release_bot/build/examples/vocabs/daphnetAncient.jsonp'
    ],
    
    modules: {
        
        'pundit.NamedContentHandler': {
            active: false 
        },

        'pundit.Help': {
            introductionFile: '/introductions/intro-ancient.html',
            introductionWindowTitle: "Welcome to AncientSource Pundit!",
            showIntroductionAtLogin: true
        },
        
        'pundit.ContactHelper': {
            instances: [
                {
                    title: 'Contact us',
                    comment: 'If you need help or have suggestions for AncientSource, send us your thoughts!',
                    list: 'modernancient'
                }
            ]
        },
    
        'pundit.NotebookManager': {
            active: false
        },
        'pundit.CommentTagPanel': {
            active: true,
            enableEntitiesExtraction: false
        }
    }
    
}