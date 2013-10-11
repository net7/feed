// TODO: nice comment explaining where to find info on this file

var punditConfig = {

    debugAllModules: false,

    annotationServerBaseURL : 'http://as.thepund.it:8080/annotationserver/',

    vocabularies: [
       ],

    useBasicRelations: false,

    modules: {
        
        'pundit.NamedContentHandler': {
            active: false 
        },

        'pundit.Help': {
			active: false
        },
        
        'pundit.ContactHelper': {
			active: false
        },
        
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
        'pundit.fasttexthandler': {
            active: false
        },
        
        'selectors': {
            'EuropeanaEDM': {
                active: false
            }
            /*
            'KorboBasket': {
                name: 'korbo', 
                label: 'Korbo search', 
                active: true,
                baskets: [82]
            }
            */
        },
        'annotators': {}
    }

};
