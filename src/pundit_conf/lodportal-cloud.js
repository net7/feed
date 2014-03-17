var punditConfig = {
    debugAllModules: false,
    annotationServerBaseURL: "http://188.226.156.66:8080/annotationserver/",
    useBasicRelations: true,
    
    modules: {
        'pundit.PageHandler': {
            active: false
        },
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
