// TODO: nice comment explaining where to find info on this file

var punditConfig = {

    debugAllModules: false,

    annotationServerBaseURL : 'http://as.thepund.it:8080/annotationserver/',

    vocabularies: [],

    useBasicRelations: false,

    modules: {
        
        'pundit.NamedContentHandler': {
            active: false 
        },

        'pundit.TooltipAnnotationViewer': {
            showInvalidXPointers: true,
            debug: false
        },

        'pundit.Help': {
            introductionFile: '/introductions/intro-burckhardt.html',
            introductionWindowTitle: "Welcome to BurckhardtSource Pundit!",
            showIntroductionAtLogin: false
        },
        
        'pundit.ContactHelper': {
            instances: [
                {
                    title: 'Contact us',
                    comment: 'If you need help or have suggestions for BurckhardtSource, send us your thoughts!',
                    list: 'burckhardt'
                }
            ]
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
            active: false,
            enableEntitiesExtraction: false
        },
        
        'selectors': {
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
