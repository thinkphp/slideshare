<?php
if(isset($_GET['user']) && $_GET['user'] != '') {
   $user = $_GET['user'];
} else {
   $user = "weierophinney";
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
   <title>Request.Slideshare</title>
   <link rel="stylesheet" href="style.css" type="text/css">
   <script src="http://www.google.com/jsapi?key=ABQIAAAA1XbMiDxx_BTCY2_FkPh06RRaGTYH6UMl8mADNa0YKuWNNa8VNxQEerTAUcfkyrr6OwBovxn7TDAH5Q"></script>
   <script type="text/javascript">google.load("mootools", "1.3");</script>
   <script src="Request.JSONP.js"></script>
   <script type="text/javascript" src="Request.Slideshare-yui-compressed.js"></script>
   <script type="text/javascript">
   window.addEvent('domready',function(){
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

   });//end domready
   </script>
</head>
<body>
<h1><span>Badge</span></h1>
<div id="doc">
<div id="bd">
<h2><a href="http://slideshare.com/<?php echo$user;?>">My latest slides</a></h2>

   <div class="yui-g">

     <div class="yui-u first" id="badge1">
             <div id="badge" class="username-<?php echo$user;?> amount-10"></div>
     </div>

    </div>
</div>
</div>
<div id="ft"><p>Created by @<a href="http://twitter.com/thinkphp">thinkphp</a> using <a href="http://thinkphp.ro/apps/YQL/slideshare.rss.xml">Open Data Table</a> | You can grab the source code of this demo on <a href="http://mootools.net/forge/download/Request_Slideshare/v1.0">Forge</a></p></div></div>
</body>
</html>

