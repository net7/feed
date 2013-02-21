/**
 * @class pundit.NamedContentHandler
 * @extends pundit.baseComponent
 * @description TODO
 */
dojo.provide("pundit.NamedContentHandler");
dojo.declare("pundit.NamedContentHandler", pundit.BaseComponent, {

    opts: {
        moreInfoTag: 'span',
        moreInfoAttribute: 'rel',
        moreInfoURL: 'http://purl.org/pundit/ont/json-metadata'
    },

    constructor: function(options) {
        var self = this;
        
        self.xphelper = new pundit.XpointersHelper();

        _PUNDIT.init.onInitDone(function(){
            self.checkForNamedContent();
            tooltip_viewer.onConsolidate(function(){
            });
        })
        
    },
    
    checkForNamedContent: function() {
        var self = this,
            uris = {}, 
            num = 0, 
            xp;
        
        // Foreach content class, look for those items and extract everything we can
        for (var i = self.xphelper.opts.contentClasses.length - 1; i >= 0; i--)
            dojo.query('.' + self.xphelper.opts.contentClasses[i]).forEach(function(node) {
                var u = dojo.attr(node, "about");
                num++;
                uris[u] = {
                    node: node,
                    xp: self.xphelper.getXpFromChildNodes(node),
                    item: self.createItemForNode(node)
                };
                self.log("checkForNamedContent adding: " + u);
                
            });
        self.log("checkForNamedContent: "+num+" named contents found");

        for (k in uris) {
            var item = uris[k].item;
            semlibItems.addItem(item, true);
            previewer.buildPreviewForItem(item);
            semlibMyItems.show_pundittabfiltermyitemsfragment();
        }
        
    }, // checkForNamedContent()
    
    createItemForNode: function(node) {
        var self = this,
            xp = self.xphelper.getXpFromChildNodes(node),
            content,
            content_short,
            pCont = window.location.href,
            item;

        content = self.xphelper.extractContentFromNode(node);
        content = content.replace(/(\r\n|\n|\r)/gm, "").replace(/\s+/g," ");
        content_short = content.length > 50 ? content.substr(0,50)+' ..' : content;
        
        // If window location is an xpointer of a selected fragment
        // don't consider the fragment!!
        if (pCont.indexOf('#xpointer') !== -1)
            pCont = pCont.substring(0, pCont.indexOf('#'));
        
        // Create the item along its bucket
        item = {
            type: ['subject'],
            rdftype: [ns.fragments.named, ns.fragments.text],
            label: content_short,
            description: content,
            value: xp,
            isPartOf: xp.split('#')[0],
            pageContext: pCont
        }
        
        item.rdfData = semlibItems.createBucketForNamedContent(item).bucket;
        
        self.log('Created an item from node with label: '+content_short);
        return item;
    },


});