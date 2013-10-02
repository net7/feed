var punditConfig = {

    debugAllModules: false,

    annotationServerBaseURL: "http://as.thepund.it:8080/annotationserver/",

    vocabularies: [
        "http://manager.korbo.org/103?jsonp=_PUNDIT.vocab.initJsonpVocab",
        "http://manager.korbo.org/112?jsonp=_PUNDIT.vocab.initJsonpVocab"
    ],
    

    useBasicRelations: false,

    modules: {

        'pundit.Help': {
            introductionFile: '/introductions/intro-galariosto.html',
            introductionWindowTitle: "Welcome to Galassia Ariosto's Pundit!",
            showIntroductionAtLogin: true
        },

        'pundit.ContactHelper': {
            active: false
        },

        'pundit.NamedContentHandler': {
            active: false
        },
        'pundit.NotebookManager': {
            active: true
        },
        'pundit.ImageFragmentHandler': {
            active: false
        },
        'pundit.ImageAnnotationPanel': {
            active: false
        },
        'pundit.PageHandler': {
            active: false
        },
        'pundit.Recognizer': {
            active: false
        },
        'pundit.CommentTagPanel': {
            active: true,
            enableEntitiesExtraction: false
        },
                
        'selectors': {
            'EuropeanaEDM': {
                active: false
            },
            'Muruca': {
                active: true,
                name: 'muruca',
                label: 'Azioni',
                MurucaReconURL: "http://demo2.galassiaariosto.netseven.it/reconcile"
            }
        },
        
        'annotators': {}
    }

};
