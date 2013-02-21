dojo.provide("pundit.CookiesStorageHandler");
dojo.declare("pundit.CookiesStorageHandler", pundit.BaseComponent, {
    
    // storeType : "cookiesStorage",
    
    constructor: function(options){
        var self = this;
        dojo.cookie("mystestcookie","mytestcookie");
        if (typeof(dojo.cookie("mystestcookie")) !== 'undefined'){
            dojo.cookie("mystestcookie",{
                expires : -1
            });
            this.createCallback(['storeRead', 'storeSave']);
            self.log('Using Cookie storage');
        }else{
            alert('Cookie Storage cannot be created. :-( Check you cookies preferences!')
            return false;
        }
        
    },
    
    exists:function(key){
        if (typeof(dojo.cookie(key)) !== 'undefined')
            return true;
        else
            return false;
    },
    
    save:function(key, val){
        var currentTime = new Date();
        dojo.cookie(key, dojo.toJson({value: val, created: currentTime.getTime()}), {expires : 30});
    },
    
    read:function(key){
        this.fireOnStoreRead(dojo.fromJson(dojo.cookie(key)));
        //return dojo.fromJson(dojo.cookie(key));
    },
    
    clearStore:function(){
        //Delete only Javascript cookie
        var cookies = document.cookie.split(";");
        for(i=0; i < cookies.length; i++)
        {
            var cookieName = cookies[i].split("=")[0];
            dojo.cookie(cookieName, "", {expires : -1});
        }
    },
    
    clearKey:function(key){
        dojo.cookie(key, '', {expires:-1});
    }
});

