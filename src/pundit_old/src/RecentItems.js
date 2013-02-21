dojo.provide('pundit.RecentItems');
dojo.declare('pundit.RecentItems', pundit.BaseComponent, {

    opts: {
        recentItemsLen: 20
    },
    
    constructor: function(options) {
        var self = this;

        self.recentItems = []

        self.initBehaviours();
        
        //TODO I just don't know what to do with my Recents
        //self.loadRecentItems();
        self.log("Recent Items up and running");
    },

    initBehaviours:function(){
//        var self = this;
//
//        dojo.subscribe("/dnd/drop", function(source, nodes, copy, target) {
//
//            // DEBUG: Marco perche' se e' il dnd di vocab l'item non va nei recent?
//            // DEBUG Buona domanda. Lo aggiungo da qualche altra parte. 
//            if (source === vocab.dndTree) 
//                return;
//            
//            //if ((source === semlibItems.itemsDnD) || (source === recon.itemsDnD)){
//                for (var i = nodes.length - 1; i >= 0; i--) {
//
//                    var id = dojo.attr(nodes[i], 'id'),
//                        item, uri;
//
//                    // This gets called after a drop, so the source might not have
//                    // the item anymore. copyOnly sources are not affected...
//                    if (typeof(source.map[id]) !== 'undefined')
//                        item = source.map[id];
//                    else if (typeof(target.map[id]) !== 'undefined')
//                        item = target.map[id];
//                    else {
//                        self.log('ERROR?!? Uknown source or target for this drop? WUT!');
//                        return;
//                    }
//
//                    self.setItemRecentFromUri(item.data.value, true);
//                    self.saveRecentItems();
//                }
//            //}
//        });
//
//        // On semlib item remove, save the recent items: a recent item
//        // could have been removed.
//        semlibInitObject.onInitDone(function() {
//            semlibItems.onItemRemoved(function() {
//                self.saveRecentItems();
//            });
//        });
        
    }, // initBehaviours()

    isRecentFromUri: function(uri) {
        var self = this,
            ret = false;
        
        semlibItems.itemsDnD.forInItems(function(item){
            if (item.data.value === uri && item.data.recent === true) 
                ret = true;
        });
        return ret;
    },

    setItemRecentFromUri: function(uri, value) {
        var self = this;

        semlibItems.setItemFieldFromUri(uri, 'recent', value);
        self.saveRecentItems();

        // If the recent filter is selected, refresh its content
        if (semlibItems.getSelectedTab() === 'filterRecent') 
            semlibItems.show_filterRecent();

        self.log('cMenu: This uri recent flag is  now '+ value +': '+ uri);
        return true;
        
    },

    saveRecentItems: function(){
        var self = this,
            recentItems = [];
        
        semlibItems.itemsDnD.forInItems(function(item){
            if (item.data.recent === true)
                recentItems.push(item.data);
        });
        
        // Remove the first item if there's too many: BUT, the first item
        // in this recentItems array is just the first in the semlibItems
        // order............ DEBUG DEBUG DEBUG DEBUG DEBUG
        // TODO: append a timestamp to any added recent items? or use a 
        // timestamp instead of "true" as flag value, and delete the
        // older recent value? 
        while (recentItems.length > self.opts.recentItemsLen) 
            recentItems.shift();
        
        if (recentItems.length > 0)
            recentStore.save('recentItems', recentItems);
        else 
            recentStore.clearKey('recentItems');
    },

    loadRecentItems:function() {
        var self = this;
        
        // Add the favorites: reading from the store, for each
        // item if it exist already, set it favorite, otherwise
        // add it as new item, with favorite = true
        if (recentStore.exists('recentItems')) {
            var recentItems = recentStore.read('recentItems');
            for (var i in recentItems.value) {
                var item = recentItems.value[i];
                if (semlibItems.uriInItems(item.value)) {
                    self.setItemRecentFromUri(item.value, true);
                } else {
                    item.recent = true;
                    previewer.buildPreviewForItem(item);
                    semlibItems.addItem(item);
                }
            }
            dojo.behavior.apply();
        } else {
            // TODO: Marco handle the case where the store is not there or we have an error
            // from the store module
        }
    }
    
});