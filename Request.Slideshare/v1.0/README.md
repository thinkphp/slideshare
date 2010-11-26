Request.Slideshare
====================

This is a small plugin MooTools which tries to retrieve slides from any user SlideShare using YQL and executing JavaScript in Open Data Table.


![Screenshot](http://farm5.static.flickr.com/4085/5109861642_27e2f6eaab_b.jpg)

How to use
----------

First you must to include the JS files in the head of your HTML document.

        #HTML
        <script type="text/javascript" src="mootools-core.js"></script>
        <script type="text/javascript" src="JSONP.js"></script>
        <script type="text/javascript" src="Request.Slideshare.js"></script>

In your JS.

       #JS
       window.addEvent('domready',function(){
         //variant 1
         var c = $('badge').get('class');
         var usernamematch = /username-(\w+)/, amountmatch = /amount-(\d+)/; 
         var username = usernamematch.exec(c);
             username = username ? username[1] : 'stoyan';  
         var amount = amountmatch.exec(c);
             amount = amount ? amount[1] : '5';  
             new Request.Slideshare(username, amount, {
                 onSuccess: function(o) {
                     if(o.results[0].indexOf('<error') != -1) {
                        if(window.console){console.log(o);}
                        var r = o.results[0]; 
                        var clean = r.replace(/<\/?error[^>]*>/,' '); 
                        $('badge').set('html','<h2 class="error">'+clean+'</h2>');

                     } else {
                        $('bd').setStyle('height','auto');
                        if(window.console){console.log(o);}
                        $('badge').set('html',o.results[0]);
                        $('badge').fade('hide'); 
                        $('badge').fade(1);
                     }
                 },
                 onRequest: function(script){
                   var span = new Element('span',{'class': 'loading'}).set('text','Loading...').inject($('badge'));
                 }  
            }).send();
 
      //variant 2
      //you can write less; called this method
      $('badge2').loadSlideshare('thinkphp', 10);
});


In your HTML.

       #HTML
       <div id="badge" class="username-stoyan amount-10"></div>       
       <div id="badge2"></div>       

### Notes:

You can view in action:

- [http://thinkphp.ro/apps/js-hacks/Request.Slideshare/v1.0/badge.html](http://thinkphp.ro/apps/js-hacks/Request.Slideshare/v1.0/badge.html)
- [http://thinkphp.ro/apps/js-hacks/Request.Slideshare/v1.0/badge.php?user=stoyan](http://thinkphp.ro/apps/js-hacks/Request.Slideshare/v1.0/badge.php?user=stoyan)
- [http://thinkphp.ro/apps/js-hacks/Request.Slideshare/v1.0/form.php](http://thinkphp.ro/apps/js-hacks/Request.Slideshare/v1.0/form.php)
- [http://thinkphp.ro/apps/js-hacks/Request.Slideshare/v1.0/form.html](http://thinkphp.ro/apps/js-hacks/Request.Slideshare/v1.0/form.html)
- [http://thinkphp.ro/apps/js-hacks/Request.Slideshare/v1.0/widget.html](http://thinkphp.ro/apps/js-hacks/Request.Slideshare/v1.0/widget.html)


### Requirements:

- MooTools Core 1.3
- MooTools More (Request.JSONP)
