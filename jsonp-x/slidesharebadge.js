//show me love to the Module Pattern
var slidesharebadge = function(){

    var container;
  
    function init(o) {

          container = document.getElementById(o.element);
          container.innerHTML = '<div class="loading">Loading...</div>';
          var username = o.username, amount = o.amount;

          if(container) {
             var yql = "use 'http://thinkphp.ro/apps/YQL/slideshare.rss.xml' as s;select * from s where user='{username}' and amount='{amount}'";
                 yql = yql.replace("{username}",username).replace("{amount}",amount);
             new YQLQuery(yql,slidesharebadge.seed,'xml').fetch();  
          }
    };

    function seed(o) {
                   if(o.results[0].indexOf('<error') != -1) {
                        if(window.console){console.log(o);}
                        var r = o.results[0]; 
                        var clean = r.replace(/<\/?error[^>]*>/,' '); 
                        container.innerHTML = '<h2>'+clean+'</h2>';

                   } else {
                        document.getElementById('bd').style.height = 'auto';
                        if(window.console){console.log(o);}
                        container.innerHTML = o.results[0];
                   }
    };
 
  return{init: init, seed: seed};
}();

