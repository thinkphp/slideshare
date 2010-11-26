/*
---
description: This is a small plugin MooTools which tries to retrieve slides from any user SlideShare using YQL and executing JavaScript in Open Data Table.

authors:
- Adrian Statescu (http://thinkphp.ro)

license:
- MIT-style license

requires:
 core/1.3: '*'
 more/1.2.4.4: Request.JSONP

provides: [Request.Slideshare]
...
*/

Request.Slideshare = new Class({
        /* Extends */
        Extends: Request.JSONP,
        /* options */
        options: {
              url: "http://query.yahooapis.com/v1/public/yql?q=use%20'http%3A%2F%2Fthinkphp.ro%2Fapps%2FYQL%2Fslideshare.rss.xml'%20as%20s%3Bselect%20*%20from%20s%20where%20user%3D%22{username}%22%20and%20amount%3D%22{amount}%22",
              data: {
                        format: 'xml',
                        diagnostics: true 
                    }
        },
        /* initialize */
        initialize: function(username, amount, options) {
                     this.options.url = this.options.url.substitute({username: username, amount: amount});  
                     this.parent(options);
        }                
}); 

Element.implement({
        loadSlideshare: function(user, amount) {
                        var target = this;
                        var amount = amount || 5;
                        if(user) {
                           new Request.Slideshare(user, amount,{
                                    onSuccess: function(o) {
                                             if(o.results[0].indexOf('<error') != -1) {
                                                  if(window.console){console.log(o);}
                                                  var r = o.results[0]; 
                                                  var clean = r.replace(/<\/?error[^>]*>/,' '); 
                                                  $(target).set('html','<h2 class="error">'+clean+'</h2>');
                                              } else {
                                                  if(window.console){console.log(o);}
                                                  $(target).set('html',o.results[0]);
                                                  $(target).fade('hide');
                                                  $(target).fade(1);
                                              }
                                    },
                                    onRequest: function(script){
                                                  if(window.console){console.log(script);}
                                                  $(target).empty();
                                                  new Element('div',{'class':'loading'}).set('text','Loading...').inject($(target));
                                    } 
                           }).send();
                        }
          return this; 
        }
});