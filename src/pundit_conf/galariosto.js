var punditConfig = {

    debugAllModules: false,

    annotationServerBaseURL: "http://demo.as.thepund.it:8080/annotationserver/",

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
            'Freebase': { active: false },
            'DBPedia': { active: false },
            'EuropeanaEDM': { active: false },
            'Wordnet': { active: false },
            'Muruca': [
                {
                    queryTypes: ['http://purl.org/galassiariosto/types/Azione'],
                    name: 'murucaazioni',
                    label: 'Azioni',
                    MurucaReconURL: "http://demo2.galassiaariosto.netseven.it/reconcile",
                    active: true
                },
                {
                    queryTypes: ['http://purl.org/galassiariosto/types/Scena'],
                    name: 'murucascene',
                    label: 'Scene',
                    MurucaReconURL: "http://demo2.galassiaariosto.netseven.it/reconcile",
                    active: false
                }
            ]

        },
        
        'annotators': {}
    }

};
