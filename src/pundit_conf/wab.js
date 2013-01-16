var punditConfig = {

    debugAllModules: false,

    annotationServerBaseURL: "http://annotationserver.netseven.it:8088/annotationserver/",

    vocabularies: [
        'http://www.wittgensteinsource.org/js/witt_subjects_taxonomy.json',
        //'http://www.wittgensteinsource.org/js/witt_sources_taxonomy.json',
        'http://www.wittgensteinsource.org/js/witt_relations.json'  
    ],
    

    useBasicRelations: false,

    modules: {

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
