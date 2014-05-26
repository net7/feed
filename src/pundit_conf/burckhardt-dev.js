// TODO: nice comment explaining where to find info on this file

var punditConfig = {

    debugAllModules: false,

    annotationServerBaseURL : 'http://demo-cloud.as.thepund.it:8080/annotationserver/',

    vocabularies: [
    // 92 @ korbo(1): Properties definition
        "http://manager.korbo.org/91?jsonp=_PUNDIT.vocab.initJsonpVocab"
    ],

    useBasicRelations: false,

    modules: {
        'pundit.ng.EntityEditorHelper': {
            endpoint: "http://dev.korbo2.org/v1",
            basketID: 1,
            active: true,
            debug: false,        
            globalObjectName : 'KK',
            useOnlyCallback: true,
            visualizeCopyButton: ['freebase'],
            visualizeEditButton: false, 
            copyToKorboBeforeUse: true,
            providers: {
                freebase: true,
                dbpedia: false
            },
            types: [
                  {
                     label: 'Person',
                     state: false,
                     URI:'http://www.freebase.com/people/person'
                   },
                   {
                      label: 'Location',
                      state: false,
                      URI:'http://www.freebase.com/location/location'
                    },
                    {
                       label: 'Institution',
                       state: false,
                       URI:'http://www.freebase.com/organization/organization'
                     },
                    {
                       label: 'Artwork',
                       state: false,
                       URI:'http://www.freebase.com/visual_art/artwork'
                     },
                     {
                        label: 'Architecture',
                        state: false,
                        URI:'http://www.freebase.com/architecture/structure'
                      },
                      {
                         label: 'Book',
                         state: false,
                         URI:'http://www.freebase.com/book/book'
                       },
                       {
                          label: 'Periodical',
                          state: false,
                          URI:'http://www.freebase.com/periodicals/periodical'
                        },
                        {
                           label: 'Journal',
                           state: false,
                           URI:'http://www.freebase.com/periodicals/journal'
                         },
                         {
                            label: 'Newspaper',
                            state: false,
                            URI:'http://www.freebase.com/periodicals/newspaper'
                          }
                  ],
        },

        'pundit.NamedContentHandler': {
            active: false 
        },

        'pundit.Help': {
            introductionFile: '/introductions/intro-burckhardt.html',
            introductionWindowTitle: "Welcome to BurckhardtSource Pundit!",
            showIntroductionAtLogin: true
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
