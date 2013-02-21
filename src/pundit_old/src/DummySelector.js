dojo.provide("pundit.DummySelector");
dojo.declare("pundit.DummySelector", pundit.BaseComponent, {

    //debug: false,
    defaultAnswer: 'http://dummy.default.answer/',

    constructor: function(options) {

        if ('answer' in options)
            this.answer = options.answer
        else
            this.answer = this.defaultAnswer;

        //this.onOkCallbacks = [];
        this.createCallback('Ok')

        this.log('DummySelector up and running');
        
    }, // constructor()

    openDialog: function() {
        this.fireOnOk(this.answer);
    }

});