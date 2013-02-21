/**
 * @class pundit.annotators.AnnotatorsConductor
 * @extends pundit.baseComponent
 * @description Drives the orchestra of pundit annotators
 * TODO TODO TODO TODO 
 */
dojo.provide("pundit.annotators.AnnotatorsConductor");
dojo.declare("pundit.annotators.AnnotatorsConductor", pundit.BaseComponent, {


    // TODO: this .opts field doesnt get extended by subclasses but overwritten!
    opts: {
        something: ['yes']
    },

    constructor: function(options) {
        var self = this;
        
        self.annotators = {};
        
        
        self.log('Annotators Conductor up and running');

    }, // constructor()
    
    registerAnnotator: function(anr) {
        var self = this;
        
        
        if (typeof(self.annotators[anr.itemRDFtype]) !== 'undefined') {
            self.log('ERROR: registering another annotator for rdf type '+anr.itemRDFtype+' ???');
            return;
        }
        
        self.annotators[anr.itemRDFtype] = anr;
        self.log('Registered annotator for type '+anr.itemRDFtype);
        
    }

    /*
    - creare item da quello che legge tramite server
    - fornire come salvare in RDF un item
    - fornire rappresentazioni HTML per preview
    - fornire rappr HTML per annotazione
    - fornire logica custom onmouseover dell'icona RDF
    */

});