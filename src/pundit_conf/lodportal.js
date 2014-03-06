var punditConfig = {
    debugAllModules: false,
    annotationServerBaseURL: "http://demo-cloud.as.thepund.it:8080/annotationserver/",
    useBasicRelations: true,
    
    modules: {
        
        'pundit.NamedContentHandler': {
            active: false 
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
