<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
   <title>Get Slideshare Badge using JSONP-X</title>
   <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<h1><span>Badge</span></h1>
<div id="doc">
<div id="bd">
<h2><a href="http://slideshare.com/thinkphp">My latest slides</a></h2>
<div id="badge" class="username-thinkphp amount-10"><div class="loading">Loading...</div></div>
</div>
</div>
<div id="ft"><p>Created by @<a href="http://twitter.com/thinkphp">thinkphp</a> using <a href="http://thinkphp.ro/apps/YQL/slideshare.rss.xml">Open Data Table</a></p></div></div>
   <script type="text/javascript">
    function seed(o) {
                   if(o.results[0].indexOf('<error') != -1) {
                        if(window.console){console.log(o);}
                        var r = o.results[0]; 
                        var clean = r.replace(/<\/?error[^>]*>/,' '); 
                        document.getElementById('badge').innerHTML = '<h2>'+clean+'</h2>';

                   } else {
                        document.getElementById('bd').style.height = 'auto';
                        if(window.console){console.log(o);}
                        document.getElementById('badge').innerHTML = o.results[0];
                   }
    };
   </script>
    <script type="text/javascript" src="http://query.yahooapis.com/v1/public/yql?q=use%20'http%3A%2F%2Fthinkphp.ro%2Fapps%2FYQL%2Fslideshare.rss.xml'%20as%20s%3Bselect%20*%20from%20s%20where%20user%3D'thinkphp'%20and%20amount%3D'10'&diagnostics=true&format=xml&callback=seed"></script> 
</body>
</html>

