// TODO: nice comment explaining where to find info on this file

var punditConfig = {

    debugAllModules: false,

    annotationServerBaseURL : 'http://as.thepund.it:8080/annotationserver/',

    vocabularies: [
        "http://korbo.netseven.it/84?jsonp=_PUNDIT.vocab.initJsonpVocab",
        "http://korbo.netseven.it/74?jsonp=_PUNDIT.vocab.initJsonpVocab"
    ],

    useBasicRelations: true,

    modules: {
        'pundit.NamedContentHandler': {
            active: true // TODO: not for cortona
        },
        'pundit.NotebookManager': {
            active: false
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
                label: 'Korbo search', 
                active: true,
                baskets: [82]
            }            
        },
        'annotators': {}
    }

};