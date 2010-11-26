/*
---

script: Request.JSONP.js

description: Defines Request.JSONP, a class for cross domain javascript via script injection.

license: MIT-style license

authors:
- Aaron Newton
- Guillermo Rauch
- Adrian Statescu

requires:
- core: 1.3/Element
- /Log

provides: [Request.JSONP]

...
*/

Request.JSONP = new Class({

     Implements: [Chain,Events,Options,Log],

     options: {
        url: '',
        data: {},
        retries: 0,
        timeout: 0,
        link: 'ignore',
        callbackKey: 'callback',
        injectScript: document.head
        /*
        onRetry: $empty(intRetries),
        onRequest: $empty(scriptElement),
        onComplete: $empty(data), 
        onSuccess: $empty(data),
        onCancel: $empty,
        log: false
        */     
     },

     initialize: function(options) {
        this.setOptions(options);
        if(this.options.log) {this.enableLog();} 
        this.running = false;
        this.requests = 0;
        this.triesRemaining = [];  
     },

     check: function() {

     },

     send: function(options) {

          var type = $type(options),old = this.options, index = $chk(arguments[1]) ? arguments[1] : this.requests++;

              options = $extend({data: old.data, url: old.url},options);  

          if(!$chk(this.triesRemaining[index])) {this.triesRemaining[index] = this.options.retries;}
          var remaining = this.triesRemaining[index]; 


          (function(){

             var script = this.getScript(options);
             this.log('JSONP retrieving script with url:' + script.get('src'));
             this.fireEvent('request',script);
             this.running = true;

             

          }).delay(Browser.Engine.trident ? 50 : 0, this);

       return this;
     },

     cancel: function(){
        if(!this.running) {return this;}
        this.running = false;
        this.fireEvent('cancel');
      return this;  
     },

     getScript: function(options) {

           var index = Request.JSONP.counter, data;
           Request.JSONP.counter++;

           switch($type(options.data)) {

                  case 'element': data = document.id(options.data).toQueryString();
                  break;
                  case 'object': case 'hash': data = Hash.toQueryString(options.data);  

           }//end switch
         

           var src = options.url + (options.url.test('\\?') ? '&' : '?') + 

                     (options.callbackKey || this.options.callbackKey) + '=Request.JSONP.request_map.request_'+index + (data ? '&'+data : '');

           if(src.length > 2083) {this.log('JSONP '+ src + ' will fail in internet explorer, which enforces a 2083 bytes lenght limit on URIs');} 

           var script = new Element('script',{type: 'text/javascript',src: src});
     
           Request.JSONP.request_map['request_'+index] = function(){this.success(arguments,script);}.bind(this);

        return script.inject(this.options.injectScript);        
     },

     success: function(args,script) {
        if(script) {script.destroy();}
        this.running = false;
        this.log('JSONP successfully retrieved: ', args);
        this.fireEvent('complete',args).fireEvent('success',args).callChain(); 
     }
    
});//end class Request.JSONP
Request.JSONP.counter = 0;
Request.JSONP.request_map = {};