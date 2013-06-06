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
        'pundit.NotebookManager': { 
            active: true, 
            notebookSharing: false,
            notebookActivation: false,
            showFilteringOptions: false,
            askBaseURL: 'http://ask.as.thepund.it/#/myNotebooks/'
        },
        
        'selectors': {},
        'annotators': {}
    }

};