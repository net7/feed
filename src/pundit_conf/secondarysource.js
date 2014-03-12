var punditConfig = {
    debugAllModules: false,
    annotationServerBaseURL: "http://as.thepund.it:8080/annotationserver/",
    vocabularies: [
       'http://manager.korbo.org/108?jsonp=_PUNDIT.vocab.initJsonpVocab',
       'http://manager.korbo.org/107?jsonp=_PUNDIT.vocab.initJsonpVocab',
       'http://manager.korbo.org/109?jsonp=_PUNDIT.vocab.initJsonpVocab'
    ],
     useBasicRelations: false,	    
    
    modules: {
	'selectors': {
		'Muruca': [
                {
                    queryType: 'http://ancientsource.daphnet.org/types/Page',
                    name: 'paragraphs-ancient',
                    label: 'Ancientsource',
                    murucaReconURL: "http://ancientsource.daphnet.org/agora_frontend.php/agora-paragraph-reconcile",
                    active: true
                },
		{
                    queryType: 'http://modernsource.daphnet.org/types/Paragraph',
                    name: 'paragraphs-modern',
                    label: 'Modernsource',
                    murucaReconURL: "http://modernsource.daphnet.org/agora_frontend.php/agora-paragraph-reconcile",
                    active: true
                }
		]
	},       

 
        'pundit.NamedContentHandler': {
            active: false 
        },

        'pundit.Help': {
            introductionFile: '/introductions/intro-modern.html',
            introductionWindowTitle: "Welcome to ModernSource Pundit!",
            showIntroductionAtLogin: true
        },
        
        'pundit.ContactHelper': {
            instances: [
                {
                    title: 'Contact us',
                    comment: 'If you need help or have suggestions for ModernSource, send us your thoughts!',
                    list: 'modernancient'
                }
            ]
        },
    
        'pundit.NotebookManager': {
            active: false
        },
        'pundit.CommentTagPanel': {
            active: true,
            enableEntitiesExtraction: false
        }
    }
    
}
