var punditConfig = {
    debugAllModules: false,
    annotationServerBaseURL: "http://as.thepund.it:8080/annotationserver/",
    vocabularies: [
       'http://manager.korbo.org/108?jsonp=_PUNDIT.vocab.initJsonpVocab',
       'http://manager.korbo.org/107?jsonp=_PUNDIT.vocab.initJsonpVocab',
       'http://manager.korbo.org/109?jsonp=_PUNDIT.vocab.initJsonpVocab'
    ],
    
    
    modules: {
        
        'pundit.NamedContentHandler': {
            active: false 
        },

        'pundit.Help': {
            introductionFile: '/introductions/intro-modern.html',
            introductionWindowTitle: "Welcome to ModernSource Pundit!",
            showIntroductionAtLogin: true
        },
        
        'pundit.ContactHelper': {
            instances: [
                {
                    title: 'Contact us',
                    comment: 'If you need help or have suggestions for ModernSource, send us your thoughts!',
                    list: 'modernancient'
                }
            ]
        },
    
        'pundit.NotebookManager': {
            active: true
        },
        'pundit.CommentTagPanel': {
            active: true,
            enableEntitiesExtraction: false
        }
    }
    
}
