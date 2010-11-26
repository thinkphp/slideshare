var slidesharebadge = function() {

     /* configurations */

     var config = {

        countDefault: 4,

        badgeID: 'slidesharebadge',

        listID: 'slidesharelist',

        stylesmatch: /skin-(\w+)/,  

        amountmatch: /amount-(\d+)/,

        styles: {

           'transparent': 'slideshare-trasparent.css'
        }

     };


/* private methods */

     var badge;

     var head;

     function init() {

        badge = document.getElementById(config.badgeID);

        head = document.getElementsByTagName('head')[0];

          if(badge) {

              link = badge.getElementsByTagName('a')[0];

                   if(link) {

                       classdata = badge.className;

                   var amount = config.amountmatch.exec(classdata);

                       amount = amount ? amount[1] : config.countDefault;

                     var skin = config.stylesmatch.exec(classdata);

                     var name = link.href.split('/');

                     var root = 'http://query.yahooapis.com/v1/public/yql?q=';

                     var yql = 'select title,link from rss where url="http://www.slideshare.net/rss/user/'+ name[name.length-1] + '" limit ' + amount;

                     var url = root + encodeURIComponent(yql) + '&diagnostics=false&format=json&callback=slidesharebadge.seed';

                        if(skin && skin[1]) {

                              loadLink(config.styles[skin[1]]);
                        };

                     var span = document.createElement('span');                         

                         span.className = 'loading';

                         badge.appendChild(span);  

                        loadScript(url,function(){

                                var loading = badge.getElementsByTagName('span')[0];
   
                                loading.parentNode.removeChild(loading);

                             if(window.console) {

                                console.log('Loaded JSON into SCRIPT NODE for slidesharebadge YQL: ' + yql);

                             };//endif    
                        }); 

                   }//end if

          }//end if       

     };//end function

   
     function loadScript(src,callback) {

             var script = document.createElement('script');

                 script.setAttribute('type','text/javascript'); 

                 //if IE
                 if(script.readyState) {

                        script.onreadystatechange = function() {

                                  if(script.readyState == 'loaded' || script.readyState == 'complete') {

                                               script.onreadystatechange = null;

                                               callback();   
                                  }   
                        };

                 //others
                 } else {

                        script.onload = function() {

                               callback();
                        };
                 }


                 script.setAttribute('src',src);

                 document.getElementsByTagName('head')[0].appendChild(script);

    };//end function



    function seed(json) {

       var results = json.query.results.item;

       if(typeof results !== 'undefined') {   

            var ul = document.createElement('ul');

                ul.id = config.listID;

                for(var i=0;i<results.length;i++) {

                  var li = document.createElement('li');

                  var a = document.createElement('a');

                      a.setAttribute('href',results[i].link); 

                      a.appendChild(document.createTextNode(results[i].title));

                      li.appendChild(a);

                      ul.appendChild(li); 

                 }//end for

          badge.appendChild(ul); 

        } else {

          badge.innerHTML = 'Error retrieve data.'; 

        }


   };


   function loadLink(skin) {

       var style = document.createElement('link');

           style.setAttribute('rel','stylesheet');

           style.setAttribute('type','text/css');

           style.setAttribute('href',skin);

           document.getElementsByTagName('head')[0].insertBefore(style,head.firstChild);

   };  


                        /* public methods */           

     return {

         seed: seed,

         init: init 
     };

}();

slidesharebadge.init();
