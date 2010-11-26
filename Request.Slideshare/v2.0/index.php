<?php
    if(isset($_GET['q']) && $_GET['q'] != '') {
      $q = $_GET['q'];
    } else {$q = 'thinkphp';}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <title>SlideShare Badge</title>
   <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css">
   <link rel="stylesheet" href="style.css" type="text/css">
   <style type="text/css">
   body,html{background:#fff;color:#333;font-family: helvetica,arial,verdana,sans-serif;}
   h1{font-size:200%;margin:0;padding:.3em;color: #fff;font-weight: bold;text-shadow:1px 3px 3px #ccc}
   #bd{background:#fff;border:1em solid #fff;height: 400px}
   #doc{border: 10px solid #fff;-moz-box-shadow:4px 4px 10px #69c;-webkit-box-shadow:4px 4px 10px #69c;margin-top: 10px;background: #31ae9e;}
   #ft p{text-align: left;padding:1em 0;color: #333;font-size: 12px;text-indent: 1em;}
   #ft a{color: #fff}
   </style>
   <script type="text/javascript" src="moo.js"></script>
   <script type="text/javascript" src="Request.JSONP.js"></script>
   <script type="text/javascript" src="Request.SlideShare.js"></script>
   <script type="text/javascript">
  //once DOM is READY THEN go ahead!
  window.addEvent('domready',function(){

             new SlideShare('<?php echo$q;?>',{

                 onSuccess: function(json) {

                    var badge = document.id(this.badgeID);document.id('bd').setStyle('height','auto');

                    if(json.query.results) {

                    var results = json.query.results.item;

                        var loading = badge.getElements('span')[0];
   
                            loading.parentNode.removeChild(loading);

                        if(typeof results !== 'undefined') {   

                            var ul = document.createElement('ul');

                                ul.id = 'slidesharelist';

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
                    }else {badge.innerHTML = '<h2>Error retrieve data.</h2>'}
                

                 },

                 onRequest: function(script){

                   if(window.console) {console.log('Inject SCRIPT into <HEAD>');console.log(script);}   

                     var span = document.createElement('span');                         

                         span.className = 'loading';

                         document.id(this.badgeID).appendChild(span);  

                 }
             },'slidesharebadge').send();             
    });                          
</script>
</head>
<body>
<div id="doc" class="yui-t7">
   <div id="hd" role="banner"><h1>SlideShare Badge</h1></div>

   <div id="bd" role="main">
	<div class="yui-g">
          <div id="slidesharebadge">
               <h2><img src="http://www.co2.ie/images/slideshare_icon.png"/>&nbsp;<a href="http://slideshare.com/thinkphp">My latest slideshare</a></h2>
          </div>
      </div>

  </div>
   <div id="ft" role="contentinfo"><p>Written By Adrian Statescu using <a href="Request.SlideShare.js">Request.SlideShare.js</a> and <a href="http://thinkphp.ro/apps/slideshare/Request.Slideshare/slideshare.table.xml">Open Data Table</a> | <a href="YQL.txt">YQL</a></p></div>
</div><!-- end doc -->

</body>
</html>
