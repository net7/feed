/**
 * @class pundit.annotators.AnnotatorsBase
 * @extends pundit.baseComponent
 * @description TODO TODO TODO TODO 
 */
dojo.provide("pundit.annotators.AnnotatorsBase");
dojo.declare("pundit.annotators.AnnotatorsBase", pundit.BaseComponent, {


    // TODO: this .opts field doesnt get extended by subclasses but overwritten!
    opts: {
        something: ['yes']
    },

    constructor: function(options) {
        var self = this;

    }, // constructor()
        
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