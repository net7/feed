dojo.provide("pundit.RemoteStorageHandler");
dojo.declare("pundit.RemoteStorageHandler", pundit.BaseComponent, {
    
    // TODO: x marco cos'e' sto store type? ci serve?
    storeType : "localStorage",
    
    constructor: function(options){
        var self = this;

        self.createCallback(['storeRead', 'storeSave', 'storeError']);
        self.reader = new pundit.AnnotationReader({debug: self.opts.debug});
        self.reader.onStorageGet(function(data){
            self.log('Storage read from server');
            if (data) {
                self.log('Firing onStoreRead');
                self.fireOnStoreRead(data);
            }
        });
        self.reader.onStorageError(function(error){
            self.fireOnStoreError();
        });
        self.writer = new pundit.AnnotationWriter();
        self.writer.onStorageError(function(error){
            self.fireOnStoreError();
        });
    },
    
    exists: function(key){
        //Currently is not useful
    },
    
    save: function(key, val){
        var currentTime = new Date(),
            payload = dojo.toJson({value: val, created: currentTime.getTime()});
        this.writer.postRemoteStorage(key, payload);
    },
    
    read: function(key){
        this.reader.getDataFromStorage(key);
    },
    
    clearStore:function(){
        //API has not been implemented yet
    },
    
    clearKey:function(key){
        //API has not been implemented yet
    }
    
});