dojo.provide("pundit.LocalStorageHandler");
dojo.declare("pundit.LocalStorageHandler", pundit.BaseComponent, {
    
    //debug : false,
    
    storeType : "localStorage",
    
    constructor: function(options){
        if (typeof(localStorage) !== 'undefined')
            this.createCallback(['storeRead', 'storeSave']);
        else
            alert('Local Storage not available in your browser :-(');
    },
    
    exists:function(key){
        if ((typeof(localStorage[key]) !== 'undefined') && (localStorage[key] !== null)) 
            return true;
        else
            return false;
    },
    
    save:function(key, val){
        var currentTime = new Date();
        localStorage[key] = dojo.toJson({value: val, created: currentTime.getTime()});
    },
    
    read:function(key){
        //this.fireOnStoreRead(dojo.fromJson(localStorage[key]));
        return dojo.fromJson(localStorage[key]);
    },
    
    clearStore:function(){
        localStorage.clear();
    },
    
    clearKey:function(key){
        if (typeof(localStorage[key]) !== 'undefined'){
            localStorage.removeItem(key);
        }
    }
    
});


