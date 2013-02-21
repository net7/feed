dojo.provide("pundit.Recognizer");
dojo.declare("pundit.Recognizer", pundit.BaseComponent, {

   constructor: function() {
       var self = this;

       self.initContextualMenu();
       self.initBehaviors();
       
       // TODO: check if selectors are active
       self.recognizerPanel = new pundit.RecognizerPanel({
            name: 'recognize',
            preview: true,
            drag: true,
            searchType: 'search',
            namedEntitiesSources: _PUNDIT.config.activeEntitySources
        });
        
//        self.recognizerPanel.onItemAdded(function(item){
//            self.suggestionPanel.addTag(item);
//            self.suggestionPanel.hide();
//        });
       
       //self.opts.debug = true;
       self.log("Recognizer up and running!");
   },
   
   init: function(nodeId) {
        
   },
   
   initGUI: function() {
       
   },
   
   initBehaviors: function() {
       
   },

    initContextualMenu: function() {
	
        var self = this;
        // Freshly selected text fragment
        
        if (_PUNDIT.config.modules['pundit.Recognizer'].showAction) {
            cMenu.addAction({
                type: ['textSelectionHelper'],
                name: 'recognizeSelection',
                label: 'Recognize selection',
                showIf: function(item) {
                    return true;
                },
                onclick: function(item) {
               
                    // TODO: init the gui here with the selection text
               
                    // TODO: move this into its own function, called on gui init
                    // to fill up the suggestions
                    var term = fragmentHandler.getLastSelectedContent();
                
                    self.recognizerPanel.performSearch(term);
                    self.recognizerPanel.show(150, 150, {
                        title: 'Recognizer',
                        target: item //DEBUG Pass it in another way?
                    });

                } // onclick
            });    
        }    
        
	
        
        
    // Recognize an already consolidated fragment
    //       cMenu.addAction({
    //           type: ['textfragment', 'selectedFragment'],
    //           name: 'recognize',
    //           label: 'Recognize item',
    //           showIf: function(xp) {
    //               return true;
    //           },
    //           onclick: function(xp) {
    //               
    //               // TODO: take the item from the manager (no matter where it comes from)
    //               // and init the GUI with item.description
    //               
    //               // _PUNDIT.items.getItemsWhereFieldTest('description', function(c) {
    //               //     return true;
    //               // });
    //
    //               return true;
    //           }
    //       });


    }, // initContextualMenu

});