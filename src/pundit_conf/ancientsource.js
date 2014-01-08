var punditConfig = {
    debugAllModules: false,
    annotationServerBaseURL: "http://as.thepund.it:8080/annotationserver/",
    vocabularies: [
       'http://korbo.netseven.it/108?jsonp=_PUNDIT.vocab.initJsonpVocab',
       'http://korbo.netseven.it/107?jsonp=_PUNDIT.vocab.initJsonpVocab',
       'http://korbo.netseven.it/109?jsonp=_PUNDIT.vocab.initJsonpVocab'
    ],
    
     modules: {     

        'pundit.NamedContentHandler': {
            active: false 
        },

        'pundit.Help': {
            introductionFile: '/introductions/intro-ancient.html',
            introductionWindowTitle: "Welcome to AncientSource Pundit!",
            showIntroductionAtLogin: true
        },
        
        'pundit.ContactHelper': {
            instances: [
                {
                    title: 'Contact us',
                    comment: 'If you need help or have suggestions for AncientSource, send us your thoughts!',
                    list: 'modernancient'
                }
            ]
        },
    
        'pundit.NotebookManager': {
            active: true
        },
        'pundit.CommentTagPanel': {
            active: true,
            enableEntitiesExtraction: false
        }
    }
    
}

//    modules: {
//        selectors: {
//              'KorboBasket':  {
//                      name: 'korbo-107', label: 'French', active: true, baskets: [107] 
//              }, 
//      },


