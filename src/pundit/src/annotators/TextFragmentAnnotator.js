/**
 * @class pundit.annotators.TextFragmentAnnotator
 * @extends pundit.baseComponent
 * @extends pundit.annotators.AnnotatorsBase
 * @description TODO TODO TODO TODO 
 */
dojo.provide("pundit.annotators.TextFragmentAnnotator");
dojo.declare("pundit.annotators.TextFragmentAnnotator", pundit.annotators.AnnotatorsBase, {

    // TODO: this .opts field doesnt get extended by subclasses but overwritten!
    opts: {
        something: ['yes']
    },

    constructor: function(options) {
        var self = this;
        
        self.itemRDFtype = "http://purl.org/pundit/ont/ao#fragment-text";
        self.selectorRDFtype = "http://purl.org/pundit/ont/ao#selector-xpointer";
        
        self.log('TextFragmentAnnotator up and running!');

    }, // constructor()
    
    registerAnnotator: function() {
        var self = this;
        _PUNDIT.conductor.register(self);
    }, // registerAnnotator()
    
    createItem: function() {
        
    },
    
    getItemRDF: function() {
        
    },
    
    getItemPreview: function() {
        
    },
    
    getItemAnnotationHTML: function() {
        
    },
    
    handleAnnotationIconMouseOver: function() {
        
    }


    /*
    - creare item da quello che legge tramite server
    - fornire come salvare in RDF un item
    - fornire rappresentazioni HTML per preview
    - fornire rappr HTML per annotazione
    - fornire logica custom onmouseover dell'icona RDF
    */

});