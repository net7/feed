var punditConfig = {

    debugAllModules: false,

    annotationServerBaseURL: "http://as.thepund.it:8080/annotationserver/",

    vocabularies: [
        'http://www.wittgensteinsource.org/js/witt_subjects_taxonomy.json',
        //'http://www.wittgensteinsource.org/js/witt_sources_taxonomy.json',
        'http://www.wittgensteinsource.org/js/witt_relations.json'  
    ],
    

    useBasicRelations: false,

    modules: {

        'pundit.Help': {
            introductionFile: '/introductions/intro-wab.html',
            introductionWindowTitle: "Welcome to WittgensteinSource's Pundit!",
            showIntroductionAtLogin: true
        },

        'pundit.ContactHelper': {
            instances: [
                {
                    title: 'Contact us',
                    comment: 'If you need help or have suggestions for WittgensteinSource, send us your thoughts!',
                    list: 'wab'
                }
            ]
        },

        'pundit.NamedContentHandler': {
            active: false 
        },
        'pundit.NotebookManager': {
            active: true
        },
        'pundit.ImageFragmentHandler': {
            active: true
        },
        'pundit.ImageAnnotationPanel': {
            active: true
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
            'KorboBasket': {
                name: 'korbo', 
                label: 'WittgensteinSource', 
                active: true,
                baskets: [82]
            }            
        },
        
        'annotators': {}
    }

};
