// TODO: nice comment explaining where to find info on this file

var punditConfig = {

    debugAllModules: false,
    annotationServerBaseURL : 'http://as.thepund.it:8080/annotationserver/',

    vocabularies: [
        'http://metasound.dibet.univpm.it/timelinejs/pundit_conf/timeline_demo_relations.jsonp',
        'http://metasound.dibet.univpm.it/timelinejs/pundit_conf/timeline_demo_taxonomy.jsonp'
    ],

    useBasicRelations: false,

    modules: {
        
        'pundit.Help': {
            introductionFile: 'http://metasound.dibet.univpm.it/timelinejs/pundit_conf/timeline-introduction.html',
            introductionWindowTitle: 'Welcome to Pundit! :)',
            showIntroductionAtLogin: true
        },
        
        'pundit.ng.ImageAnnotatorHelper': {
            active: true,
            debug: true
        },
        
        'pundit.NotebookManager': {
            active: true,
            notebookSharing: true,
            notebookActivation: true,
            showFilteringOptions: true,
            defaultFilteringOption: 'all', // valid options: 'all' | 'active'
            activateFromAnnotations: true,
            askBaseURL: 'http://ask.as.thepund.it/#/myNotebooks/',
            debug: false
        },
        
        'pundit.TooltipAnnotationViewer': {
            active: true,
            allowAnnotationEdit: true
        },
        
        'pundit.TooltipAnnotationViewer': {
            active: true,
            allowAnnotationEdit: true
        },
        
        'selectors': {},
        'annotators': {}
    }

};