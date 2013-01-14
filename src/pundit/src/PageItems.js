dojo.provide("pundit.PageItems");
dojo.declare("pundit.PageItems", pundit.Items, {
    constructor:function(){
        var self = this;
        //self.name = 'Items';
        self.name = 'page-items';
        self.init(self.name);
        self.initBehaviors(self.name);
        self.initContextualMenu();

// FIXME: WHAT IS THE PURPOSE OF THE FOLLOWING CODE? IT IS CALLED BEFORE ITEMS ARE LOADED AND HAS THE EFFECT TO CREATE NEW ITEMS WITH WRONG METADATA!
/*        
        _PUNDIT.init.onInitDone(function(){
            tooltip_viewer.onConsolidate(function(){
                for (var xp in tooltip_viewer.xpointersClasses) {
                    var co = tooltip_viewer.xpointersContent[xp],
                    la = co.length > 20 ? co.substr(0,20)+' ..' : co;
            
                    // Add retrieved items to semlibItems, ready to be used
                    if (!self.uriInItems(xp)){
                        var item = {
                            type: ['subject'],
                            rdftype: [ns.fragments.text],
                  
                    label: la,
                            content: co,
                            value: xp,
                    
                            // DEBUG: is this correct? cutting the xpointer?
                            isPartOf: xp.split('#')[0],
                            pageContext: window.location.href
                        };
                        // Create the needed bucket and init the preview for this item
                        item.rdfData = self.createBucketForTextFragment(item).bucket;
                        previewer.buildPreviewForItem(item);
                        self.addItem(item);
                    }

                }
            });
        });
*/
      
    },
    
    
    initContextualMenu:function(){
        var self = this;
        //Add to myItems
        cMenu.addAction({
            //type: ['semlibItems'],
            type: ['pundit-page-items'],
            name: 'pageItemsToMyItems',
            label: 'Add to My Items',
            showIf: function(item) {
                return !semlibMyItems.uriInItems(item.value);;
            },
            onclick: function(item) {
                semlibMyItems.addItem(item, true);
                return true;
            }
        });
        //Remove from myItems
        cMenu.addAction({
            //type: ['semlibItems'],
            type: ['pundit-page-items'],
            name: 'removeVocabFromMyItems',
            label: 'Remove from My Items',
            showIf: function(item) { 
                return semlibMyItems.uriInItems(item.value);
            },
            onclick: function(item) {
                semlibMyItems.removeItemFromUri(item.value);
                return true;
            }
        });
        cMenu.addAction({
            type: ['pundit-' + self.name],
            name: 'open'+ self.name +'ResourceItemWebPage',
            label: 'Open Web page',
            showIf: function(item) {
                if (_PUNDIT.items.isTerm(item))
                    return true;
                else
                    return false;
            },
            onclick: function(item) {
                window.open(item.value, 'SemLibOpenedWebPage');
                return true;
            }
        });
    }
});