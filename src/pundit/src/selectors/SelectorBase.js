/**
 * @class pundit.selectors.SelectorBase
 * @extends pundit.baseComponent
 * @description Base class for Pundit Selectors. 
 * TODO TODO TODO TODO 
 */
dojo.provide("pundit.selectors.SelectorBase");
dojo.declare("pundit.selectors.SelectorBase", pundit.BaseComponent, {


    // TODO: this .opts field doesnt get extended by subclasses but overwritten!
    opts: {

        // Number of items to display in the suggestion list
        limit: 100,

        // Minimum number of characters to trigger a query to the server 
        keywordMinimumLength: 3,

        // Ms to wait after a keystroke before querying the service
        keyInputTimerLength: 500,
        
        layouts: ['pundit-view-list', 'pundit-view-tile']
    },

    constructor: function(options) {

        var self = this;
        
        // TODO abort if name is already taken? Add a string and make it unique?
        self.name = options.name;
        self.label = options.label || options.name;

        self.initPanel();
        self.initDnD();

        self._lastKeyword = '';
        
        self.keyInputTimer = null;
        self.initBehaviors();
        
        self.log('Selector '+self.name+' base setup completed.');

    }, // constructor()

    initDnD: function() {
        var self = this;

        // items does not accept any item; dnd copies items from it
        self.itemsDnD = new dojo.dnd.Source(self._id+'-items', {
            copyOnly: true, 
            creator: semlibItems.itemNodeCreator,
            checkAcceptance: function() { return false; }
        });
    },
    
    initPanel: function() {
        var self = this,
            html = '';

        self._id = 'pundit-sel-' + self.name; 
            
        html += '<div id="'+self._id+'" class="pundit-sel-container semlib-panel">';
        html += '   <div><input type="text" placeholder=".. search!" id="'+self._id+'-input" class="pundit-sel-dialog-input" />';
        html += '       <span id="'+self._id+'-message" class="pundit-sel-message"></span>';
        html += '       <span class="pundit-sort-items pundit-view-tile"></span><span class="pundit-sort-items pundit-view-list pundit-selected"></span>';
        html += '   </div>';
        html += '   <div class="pundit-items-container">';
        html += '       <ul id="'+self._id+'-items" class="pundit-items pundit-view-list"></ul>';
        html += '       <span class="pundit-error-message">' + self.name + ' is not responding</span>';
        html += '   </div>';
        html += '</div>';

        dojo.query('#pundit-vocabs-container ul.pundit-item-filter-list').append('<li id="'+self._id+'-filter">'+self.label+'</li>');

        // TODO: factor this elsewhere, PLEASE, for example the container could
        // accept a name and the markup for the panel, and init the thing by himself
        dojo.connect(dojo.byId(self._id+'-filter'), 'onclick', function(){
            dojo.query('#pundit-vocabs-container div.pundit-tab-content div.semlib-panel').removeClass('semlib-selected');
            dojo.addClass(self._id, 'semlib-selected');

            dojo.query('#pundit-vocabs-header li').removeClass('pundit-selected');
            dojo.addClass(self._id+'-filter', 'pundit-selected');
        });
            
        dojo.query('#pundit-vocabs-container div.pundit-tab-content').append(html);
        
    },
    
    initBehaviors: function() {
        var self = this,
            selBeh = {};
        
        // Key up listener, after a timer will initialize the remote call
        // to feed the list
        dojo.connect(dojo.byId(self._id+'-input'), 'onkeyup', function (evt) {
            
            self.setLoading(false);
            clearTimeout(self.keyInputTimer);
            self.keyInputTimer = setTimeout(function() {
                
                // TODO: disable the input until the results are back ?
                var keyword = dojo.byId(self._id+'-input').value;
                if (keyword !== self._lastKeyword && keyword.length >= self.opts.keywordMinimumLength) {
                    self._lastKeyword = keyword;
                    self.log('Show suggestions for term '+keyword+' on selector '+self.name);
                    self.showSuggestionsForTerm(dojo.byId(self._id+'-input').value);
                }
                
            }, self.opts.keyInputTimerLength);
        });
        
        // List item mouseover: show more info for this item
        // TODO: move this to a function the user can overwrite
        selBeh['#'+self._id+'-items li.dojoDndItem'] = {
                'onmouseover': function (e) {
                    // This gets called when hovering on every element inside this LI
                    var id = (dojo.hasClass(e.target, 'pundit-icon-context-button')||dojo.hasClass(e.target, 'pundit-trim')) ? dojo.query(e.target).parent()[0].id : e.target.id;
                    return self.dndItemMouseOverHandler(id);
                },
                'onmouseout': function(e) {
                    if (e.target.className.match('dojoDndItem'))
                        return self.dndItemMouseOutHandler(e.target.id);
                },
                'onclick':function(e) {
                    var target = e.target;
                    while (!dojo.hasClass(dojo.query(target)[0], 'dojoDndItem'))
                        target = dojo.query(target).parent()[0];
                    var id = target.id;
                    self.itemsDnD.selectNone();
                    self.itemsDnD.selection[id] = 1;
                }
            };
            
        // Contextual menu trigger
        // TODO: move this to a function the user can overwrite
        selBeh['#'+self._id+'-items span.pundit-icon-context-button'] = {
                'onclick': function (e){
                    var item = self.itemsDnD.getItem(dojo.query(e.target).parent()[0].id).data;
                    cMenu.show(e.pageX - window.pageXOffset, e.pageY - window.pageYOffset, item, 'vocabItem');
                }
            };
        dojo.behavior.add(selBeh);
        
    }, // initBehaviors()
    
    dndItemMouseOverHandler: function(id) {
        var self = this,
            item = self.itemsDnD.getItem(id).data;

        if (!previewer.exists(item.value))
            previewer.buildPreviewForItem(item);
        previewer.show(item.value);

        return false;
    },
    dndItemMouseOutHandler: function() {
        return false;
    },
    
    setLoading: function(v) {
        var self = this,
            r = dojo.query('#' + self._id),
            c = 'pundit-panel-loading';
        return (v) ? r.addClass(c) : r.removeClass(c);
    },

    /**
    * @method setItemsLayout
    * @description Switches the layout of the presented items and rearrange
    * them accordingly.
    * @param name {string} Name of the layout. See constructor options.layouts
    */
    setItemsLayout: function(name) {
        var self = this,
            layouts = self.opts.layouts; 

        dojo.query('#reconSelectorHeader .pundit-sort-items').removeClass('pundit-selected');
        dojo.query('#reconSelectorHeader .pundit-sort-items.'+name).addClass('pundit-selected');

        for (var i = layouts.length;i--;) 
            dojo.query('#reconItems').removeClass(layouts[i]);
    
        dojo.query('#reconItems').addClass(name);
    },

    // Shows the suggestions in the panel, for the given term
    showSuggestionsForTerm: function(term) { 
        var self = this;
        self.setLoading(true);
        self.getItemsForTerm(term, 
            function(items) {
                self.itemsDnD.selectAll();
                self.itemsDnD.deleteSelectedNodes();
                dojo.removeClass(dojo.query(self._id + ' .pundit-items-container'), 'pundit-lookup-error');
                dojo.empty(self._id+'-items');

                if (items.length === 0) {
                    dojo.query('#'+ self._id +'-message').html('No results found ...');
                } else {
                    dojo.query('#'+ self._id +'-message').html(items.length+' results found:');

                    self.itemsDnD.insertNodes(false, items);
                    dojo.behavior.apply();
                }
                self.setLoading(false);
            },
            function(){
                self.setLoading(false);
                dojo.addClass(dojo.query('#' + self._id + ' .pundit-items-container')[0], 'pundit-lookup-error');
            });
                
    }, // showSuggestionsForTerm()
    
    // (async) Return a list of items for the given term, calling the callback func
    getItemsForTerm: function(term, func) {
        var self = this;
        self.log('ERROR: Selector '+self.name+' does not implement getItemsForTerm');
    },
    cancelRequests:function(){
        var self = this;
        self.log('ERROR: Selector '+self.name+' does not implement cancelRequests');
    }

});