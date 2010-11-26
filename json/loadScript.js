    function loadScript(url,callback) {

             var script = document.createElement('script');

                 script.setAttribute('type','text/javascript');

                 if(script.readyState) {

                      script.onreadystatechange = function() {

                               if(script.readyState == 'loaded' || script.readyState == 'complete' ) {

                                      script.onreadystatechange = null;

                                      callback(); 
                               }  
                      }

                 } else {

                      script.onload = function(){

                             callback();
                      } 
                 }   

                 script.setAttribute('src',url);

                 document.getElementsByTagName('head')[0].appendChild(script); 
    };
