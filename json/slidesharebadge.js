//show me love to the Module Pattern
var slidesharebadge = function(){

    var container;
  
    function init(o) {

          badge = document.getElementById(o.element);
          badge.innerHTML = '<div class="loading">Loading...</div>';
          var username = o.username;
          if(badge) {
             var endpoint = "http://query.yahooapis.com/v1/public/yql?q=";
             var yql = "use 'http://thinkphp.ro/apps/slideshare/Request.Slideshare/slideshare.table.xml' as slideshare; select * from slideshare where username='"+username+"'";             
             var url = endpoint + encodeURIComponent(yql) + '&format=json&callback=slidesharebadge.seed&diagnostics=false';
             loadScript(url,function(){if(window.console){console.log("YQL statement: "+yql)}});
          }//endif
    };

    function seed(json) {

              if(window.console){console.log(json);}  


              if(json.query.results) {

                    var results = json.query.results.item;

                    document.getElementById('bd').style.height = 'auto';

                        var loading = badge.getElementsByTagName('div')[0];
   
                            loading.parentNode.removeChild(loading);

                        if(typeof results !== 'undefined') {   

                            var ul = document.createElement('ul');

                                ul.className = 'slidesharebadge';

                            for(var i=0;i<results.length;i++) {

                                var li = document.createElement('li');

                                var a = document.createElement('a');

                                    a.setAttribute('href',results[i].link); 

                                    a.appendChild(document.createTextNode(results[i].title));

                                    li.appendChild(a);

                                    ul.appendChild(li); 

                            }//end for
                         }

                        badge.appendChild(ul);
 
               } else {

                 badge.innerHTML = 'Error retrieve data.'; 

               }

    };
 
  return{init: init, seed: seed};
}();
