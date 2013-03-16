// TODO: nice comment explaining where to find info on this file

var punditConfig = {

    debugAllModules: false,

    annotationServerBaseURL : 'http://as.thepund.it:8080/annotationserver/',

    vocabularies: [
        "http://korbo.netseven.it/84?jsonp=_PUNDIT.vocab.initJsonpVocab"
    ],

    useBasicRelations: true,

    modules: {
        'pundit.ContactHelper': {
            instances: [
                {
                    title: 'Contact us!',
                    comment: 'Example form, say something to us!',
                    list: 'test2'
                }
            ]
        },
        
        'pundit.NamedContentHandler': {
            active: false // TODO: not for cortona
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