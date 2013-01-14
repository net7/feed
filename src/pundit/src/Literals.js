dojo.provide('pundit.Literals');
dojo.declare('pundit.Literals', pundit.BaseComponent, {
    
    constructor: function(options) { },
            
    createLiteralItem: function(literalValue){
        var item = {},
            label = literalValue;
        
        if (typeof(literalValue) !== 'undefined') {            
        
            if (label.length > 20)
                label = literalValue.substring(0, 20) + '...';
        
            item.type = ['object'];
            item.value = literalValue;
            item.rdftype = [ns.rdfs_literal];
            item.rdfData = [];
            item.label = label;
            
            // TODO DEBUG: x marco perche' il literal creator dovrebbe chiamare previewer? :|
            previewer.buildPreviewForItem(item);
            return item;
        }
    }
});
