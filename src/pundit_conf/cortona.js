// TODO: nice comment explaining where to find info on this file

var punditConfig = {

    debugAllModules: false,

    annotationServerBaseURL : 'http://as.thepund.it:8080/annotationserver/',

    vocabularies: [
        "http://korbo.netseven.it/84?jsonp=_PUNDIT.vocab.initJsonpVocab"
    ],

    useBasicRelations: true,

    modules: {

        'pundit.NotebookManager': {
            active: false
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
            
            'KorboBasket': {
                name: 'korbo', 
                label: 'Korbo search', 
                active: true,
                baskets: [81]
            }            
        },
        'annotators': {}
    }

};