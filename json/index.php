<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
   <title>Get Slideshare Badge using JSONP</title>
   <link rel="stylesheet" href="style.css" type="text/css">
   <script type="text/javascript" src="loadScript.js"></script>
   <script type="text/javascript" src="slidesharebadge.js"></script>
</head>
<body>
<h1><span>Badge</span></h1>
<div id="doc">
<div id="bd">
<h2><a href="http://slideshare.com/thinkphp">My latest slides</a></h2>
<div id="badge" class="username-thinkphp amount-10"></div>
</div>
</div>
<div id="ft"><p>Created by @<a href="http://twitter.com/thinkphp">thinkphp</a> using <a href="http://thinkphp.ro/apps/YQL/slideshare.rss.xml">Open Data Table</a></p></div></div>

   <script type="text/javascript">
(function(){
      var c = document.getElementById('badge').className;
      var usernamematch = /username-(\w+)/, amountmatch = /amount-(\d+)/; 
      var username = usernamematch.exec(c);
          username = username ? username[1] : 'stoyan';  
      var amount = amountmatch.exec(c);
          amount = amount ? amount[1] : '5';  
          slidesharebadge.init({element: 'badge','username': username, amount:amount}); 
})();
   </script>
</body>
</html>

