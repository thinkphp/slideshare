<?php

        //if url is set then hold in variable username $_GET['url']
        if(isset($_GET['url']) && strlen($_GET['url'])>0) {

                 $username = trim($_GET['url']);

        } else {

                 $username = "thinkphp";
        }

        if(isset($_GET['trans']) && strlen($_GET['trans'])>0) {

                 $trans = trim($_GET['trans']);

                  /*
                 //method#1
                 $root1 = 'http://query.yahooapis.com/v1/public/yql?q=';

                 $yql1 = 'select * from html where url="'.$trans.'" and xpath="//ol"';

                 $q1 = $root1 . urlencode($yql1). '&format=xml&diagnostics=false';

                 $outputtranscript = renderTranscript($q1);       
                 */

                 //method#2            
                 $root2 = 'http://query.yahooapis.com/v1/public/yql?q=';

                 $yql2 = 'use "http://isithackday.com/hacks/ohd-london/slidesharetranscript.xml" as trans; select * from trans where url="'.$trans.'"';

                 $q2 = $root2 . urlencode($yql2). '&format=xml&diagnostics=false';

                 $outputtranscript = renderTranscript2($q2);       
        }

        $root = 'http://query.yahooapis.com/v1/public/yql?q=';

        $yql = 'select content.description,title,link,description,content.thumbnail,meta.views,content.text from rss where url="http://www.slideshare.net/rss/user/'.$username.'"';

        $query = $root . urlencode($yql). '&format=json&diagnostics=false'; 

        $content = get($query);

        $json = json_decode($content);

        $output = '<ul id="slides">';

        $counter = 0;

            //if we have the results then do it
           if(is_array($json->query->results->item)) {

                 //loop over the items
                 foreach($json->query->results->item as $i) {

                            $text = preg_replace("/float:right/","float:left",$i->content->text->content);

                            $output .= '<li id="slide'.$counter.'">';

                            $output .= '<a href="'.$i->link.'">'.$i->title.'</a><p>'.$text.'</p><a class="trans" href="index.php?url='.$username.'&trans='.$i->link.'#slide'.$counter.'">Show Transcript</a>';

                             //if is equal the clicked link with current link then show the transcript
                             if($trans == $i->link) {

                                          $output .= $outputtranscript;
                            }

                            $output .= '</li>';

                            //increase the counter ++
                            $counter++;

                 }//endforeach

           }//endif     

        $output .= '</ul>';

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
   <title>SlideShare Transcript Viewer</title>
   <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css">
   <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/base/base.css" type="text/css">
   <style type="text/css">

  html,body{background:#369;color:#000}

  html{border-top:3em solid #000}

  h1{top:-2.5em;left:5em;color:#fff;position:absolute;background:transparent;text-align:center;font-size:250%}

  h1,h2,form{font-family:calibri,arial,sans-serif}

  #doc{position:relative}

  #ft{color:#fff;font-size:90%;text-align:center;margin:1em 0 2em 0}

  #ft a {color:#ccc}

  form{background:#ccf;color:#000;border:5px solid #ccf;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;padding: .3em;font-size:160%;text-align:center}

  label{padding-right:.5em}

  #slides li img{position:absolute; top:10px;left: 10px;background: #fff; border: 15px solid #fff;-moz-border-radius:5px;-webkit-border-radius:5px; border-radius: 5px}
  #slides {margin: 0; padding: 0}
  #slides li{margin: 1em;position:relative;padding:0 0 1em 150px;list-style:none;background:#ccc;border:5px solid #ccc;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;min-height:100px;_height:100px}
  #slides a{color:#369}
  #slides li h2{margin:0;padding:.2em 0 .5em 0}
  ul#slides li:hover{background:#999;border-color:#999;cursor:pointer}

  #slides ol {margin: 10px;padding: 1em 0;background:#fff;border:5px solid #fff;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px}
  #slides ol li{padding: 5px;height:auto;min-height:1em;margin:0;background:#fff;border:none;}
  #slides ol li{list-style-type: decimal;}

  </style>
</head>
<body>
<div id="doc" class="yui-t7">

   <div id="hd" role="banner"><h1>SlideShare Transcript Viewer</h1></div>

   <div id="bd" role="main">

	<div class="yui-g">

            <form action="index.php">
                 <div><label for="url">http://slideshare.com/</label><input type="text" id="url" name="url" value="<?php echo$username;?>"><input type="submit" value="Get Slides"></div>
           </form>


	</div>
        <div class="yui-g">

             <?php echo$output; ?>

	</div>

   </div><!--end bd -->

   <div id="ft" role="contentinfo"><p>Written by<a href="http://thinkphp.ro"> Adrian Statescu. </a> Using YUI and SlideShare</p></div>

</div><!--end doc -->

<script type="text/javascript">

         if(window.addEventListener) {

                  var s = document.getElementById('slides'); 

                      s.addEventListener('click',function(e){

                                    var target = e.target;

                                        if(target.nodeName.toLowerCase() !== 'ul') {

                                                while(target.nodeName.toLowerCase() !== 'li') {

                                                      target = target.parentNode; 
                                                } 

                                                var link = getElementsByClassName('trans',target,'a');

                                                           window.location = link;
                                         }
                      },false);        

         } else if(window.attachEvent) {

                  var s = document.getElementById('slides'); 

                      s.attachEvent('onclick',function(e){

                                    var target = window.event.srcElement;

                                        if(target.nodeName.toLowerCase() !== 'ul') {

                                                while(target.nodeName.toLowerCase() != 'li') {

                                                      target = target.parentNode; 
                                                } 

                                                var link = getElementsByClassName('trans',target,'a');

                                                           window.location = link;
                                         }
                      });        


         }

         function getElementsByClassName(searchClass,node,tag) {

                  var pattern = new RegExp('(^|\\\\s)'+ searchClass +'(\\\\s|$)');   

                  var arr = [];

                  if(node == null) {node = document;}

                  if(tag == null) {tag = "*";}

                  var elem = node.getElementsByTagName(tag);

                  var j = 0;

                      for(var i=0;i<elem.length;i++) {

                                if(pattern.test(elem[i].className)) {

                                         arr[j++] = elem[i];
                                }
                      }//endfor

             return arr;
         }

</script>

</body>
</html>
<?php

        //show love to the cURL
        function get($url) {

                 $ch = curl_init();

                 curl_setopt($ch,CURLOPT_URL,$url);

                 curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 

                 curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,2);

                 $data = curl_exec($ch);

                 curl_close($ch);

                 if(empty($data)) {

                         return "Server timeout.";

                 } else {
 
                        return $data;
                 }
        }
 
        //show me love to the RegExp and Transcript
        function renderTranscript($q) {

                 $x = get($q);

                 $x = preg_replace('/<!--.*-->/','',$x);

                 $x = preg_replace("/.*<results>|<\/results>/",'',$x);

                 $x = preg_replace("/<\/query>/",'',$x);

                 $x = preg_replace("/<\?xml version=\"1\.0\" encoding=\"UTF-8\"\?>/",'',$x);

              return $x;  

        }//end function


        //show me love to the RegExp and Transcript
        function renderTranscript2($q) {

                 $x = get($q);

                 $x = preg_replace('/<!--.*-->/','',$x);

                 $x = preg_replace("/.*<results>|<\/results>/",'',$x);

                 $x = preg_replace("/<\/query>/",'',$x);

                 $x = preg_replace("/<\?xml version=\"1\.0\" encoding=\"UTF-8\"\?>/",'',$x);

                 $x = preg_replace("/.*<transcript>/",'',$x);

                 $x = preg_replace("/<\/transcript><\/item>/",'',$x);

              return $x;  

        }//end function
     
?>