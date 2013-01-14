dojo.provide("pundit.TriplesBucket");
dojo.declare("pundit.TriplesBucket", null, {
    opts: {},
    
    constructor: function(options) {

        if (options && typeof(options.bucket) !== 'undefined')
            this.bucket = options.bucket;
        else
            this.bucket = [];

    }, // constructor()
    
    concatBucket: function(b) {
        this.bucket = this.bucket.concat(b);
    },
    
    addTriple: function(s, p, o, otype) {
        // TODO: avoid duplicates? cant use in .. how to look for an item?! 
        // or maybe just delay this to some get* method

        // Dont write anything if something is undefined
		if (typeof(s) !== 'undefined' && typeof(p) !== 'undefined' && typeof(o) !== 'undefined' && typeof(otype) !== 'undefined') 
			this.bucket.push({s: s, p: p, o: o, otype: otype});
		
    },
    
    emptyBucket: function() {
        this.bucket = [];
    },
    
    getTalisJson: function() {
        var res = {}, t;
        for (var i=0; i< this.bucket.length; i++) {
            t = this.bucket[i];
            
            // First time we see this pundit-subject? Add an object for the predicates
            if (!(t.s in res)) res[t.s] = {};
            
            // First time we see this predicate for this pundit-subject? 
            // Add an array for the literals
            if (!(t.p in res[t.s])) res[t.s][t.p] = [];
            
            // Push the literal
            res[t.s][t.p].push({value: t.o, type: t.otype});
        }
        return res;
    },

    // Gets the value of the object of a triple with the given
    // pundit-subject and predicate
    getObject: function(s, p) {
        var ret = [],
            t;
        for (var i in this.bucket) {
            t = this.bucket[i];
            if (t.s === s && t.p === p)
                ret.push(t.o)
        }
        return ret;
    },
    
    isEmpty: function() {
        return this.bucket.length === 0;
    }
    
});