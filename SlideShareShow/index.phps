<?php
 
   if(isset($_GET['user']) && $_GET['user'] != '') {
 
        $username = $_GET['user'];

   } else {

        $username = 'thinkphp';
   }
 
   $url = 'http://www.slideshare.net/rss/user/'.$username;
   
   $endpoint = 'http://query.yahooapis.com/v1/public/yql?q=';

   $yql = "select title,link,embed from rss where url='$url'";

   $query = $endpoint. urlencode($yql). '&format=xml&diagnostics=false';

   $output = get($query);

   $output = preg_replace('/slideshare:embed/','slideshareembed',$output);

   $output = preg_replace('/<!.*src="([^"]+)".*\]>/e',"preg_replace('/&/','&amp;','\\1')",$output);

   $slides = simplexml_load_string($output);

   $json = array();

   $slidesharelist = '';

   foreach($slides->results->item as $i) {

           $slidesharelist .= '<li><a href="'.$i->link.'">'.$i->title.'</a></li>';  

           $json[] = '\''.trim($i->slideshareembed).'\'';
   }

   function get($url) {

          $ch = curl_init();

          curl_setopt($ch,CURLOPT_URL,$url);

          curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

          curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,2);

          $data = curl_exec($ch);

          curl_close($ch);  

          if(empty($data)) {

            return 'Error retrieve data, please try again.';

          } else {return $data;}   

    }//endfunction

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <title>SlideShareShow</title>
   <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css">
   <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/base/base.css" type="text/css">
   <link rel="stylesheet" href="slideshare-trasparent.css" type="text/css">
   <style type="text/css">
    body,html{background:#fff;color:#333;font-family: helvetica,arial,verdana,sans-serif}
    h1{font-size:200%;margin:0;padding:.3em;color: #fff;font-weight: bold;text-shadow:1px 3px 3px #ccc}
   #bd{background:#fff;border:1em solid #fff;height: 400px}
   #doc{border: 10px solid #fff;-moz-box-shadow:4px 4px 10px #69c;-webkit-box-shadow:4px 4px 10px #69c;margin-top: 10px;background: #69c;}
   #slideshareshowslideshow{position:absolute;top:110px;left:450px;background:#ccc;width:425px;height:355px;}
   #slidesharelist a.current{background: #69c;color: #fff;font-weight: bold}
   #slidesharelist a:hover{background: #ddd;color: #444;}
   #ft p{text-align: left;padding:1em 0;color: #ccc;font-size: 12px;text-indent: 1em;}
   </style>
</head>
<body>
<div id="doc" class="yui-t7">
   <div id="hd" role="banner"><h1>SlideShareShow</h1></div>
   <div id="bd" role="main">
	<div class="yui-g">

          <div id="slidesharebadge" class="skin-transparent amount-5">
               <h2><img src="http://www.co2.ie/images/slideshare_icon.png"/>&nbsp;<a href="http://slideshare.com/thinkphp">My latest slideshare</a></h2>
               <ul id="slidesharelist">
                   <?php echo$slidesharelist;?>
               </ul> 
          </div>

      </div>
  </div>
   <div id="ft" role="contentinfo"><p>Written By Adrian Statescu</p></div>
</div><!-- end doc -->

<script type="text/javascript" src="http://yui.yahooapis.com/2.3.1/build/yahoo-dom-event/yahoo-dom-event.js"></script>
<script type="text/javascript" src="swfobject.js"></script>
<script type="text/javascript">
if(typeof THINKPHP == 'undefined') {THINKPHP = {};}
THINKPHP.slideshare = {};
THINKPHP.slideshare.slideshareshow = function(){
     var container = document.getElementById('slidesharebadge');
     YAHOO.util.Dom.addClass(container,'jsenabled');
     var list = document.getElementById('slidesharelist');
     var links = list.getElementsByTagName('a');
     var displayContainer = document.createElement('div');
         displayContainer.id = 'slideshareshowslideshow';
         container.appendChild(displayContainer);
     var current = null;
         for(var i=0;i<links.length;i++) {
             YAHOO.util.Event.on(links[i],'click',show,i);
         }   
     function show(e,i) {
        YAHOO.util.Dom.removeClass(current,'current');
        current = this; 
        displayContainer.innerHTML = '';
        var s = new SWFObject(slides[i],'slideshareshow',"425","355","8","#ffffff");
        s.addParam("allowScriptAccess","always");  
        s.addParam("allowFullScreen","true");
        s.write(displayContainer);
        YAHOO.util.Dom.addClass(current,'current');
        YAHOO.util.Event.stopEvent(e);
     }
     var slides = [<?php echo implode($json,',');?>];
}();
</script>
</body>
</html>
