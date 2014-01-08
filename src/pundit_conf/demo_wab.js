var punditConfig = {

    debugAllModules: false,

    annotationServerBaseURL: "http://demo.as.thepund.it:8080/annotationserver/",

    vocabularies: [
        'http://feed.thepund.it/pundit_vocabs/witt_subjects_taxonomy_v.1.3.json',
        'http://feed.thepund.it/pundit_vocabs/witt_persons_taxonomy_v.1.3.json',
        'http://feed.thepund.it/pundit_vocabs/witt_relations_v.1.4.json'
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
                },
                {
                    title: 'Suggest a predicate',
                    comment:    'If you believe you need more predicates to structure your triples, tell us! '+
                                'Please detail what kind of content you would like to use as subject and object.',
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
                label: 'WAB:Sources', 
                active: true,
                baskets: [82],
		keywordMinimumLength: 4
            }            
        },
        
        'annotators': {}
    }

};
