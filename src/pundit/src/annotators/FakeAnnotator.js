/**
 * @class pundit.annotators.FakeAnnotator
 * @extends pundit.baseComponent
 * @description Drives the orchestra of pundit annotators
 * TODO TODO TODO TODO 
 */
dojo.provide("pundit.annotators.FakeAnnotator");
dojo.declare("pundit.annotators.FakeAnnotator", pundit.annotators.AnnotatorsBase, {

    constructor: function(options) {
        var self = this;
        
        self.itemRDFtype = "http://purl.org/pundit/ont/ao#fragment-FAKE";
        self.selectorRDFtype = "http://purl.org/pundit/ont/ao#selector-FAKE";
        
        self.log('FAKE Annotator up and running!');

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