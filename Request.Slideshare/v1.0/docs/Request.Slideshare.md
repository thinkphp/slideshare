Class: Request.Slideshare {#Request.Slideshare}
=========================================================

This is a small plugin MooTools which tries to retrieve slides from any user SlideShare using YQL and executing JavaScript in Open Data Table.

### Extends:

Request.JSONP (creates a JSON request using script tag injection and handles the callbacks for you).


Request.Slideshare Method: constructor {#Request.Slideshare: constructor}
----------------------------------------------------------------------------------

### Syntax:

    var sh = new Request.Slideshare(user, amount, options);


### Arguments:

1. username (*String*) the desired username SlideShare.
2. amount (*Integer*) the desired number of slides from user SlideShare.
3. options (*object*) An object containing the Request.Slideshare instance's options.
Note: all the options you know from the class Request.JSONP because we have an inheritance.

### Returns:

(*Object*) This instance of Request.Slideshare.

### Events:

All the events you know from Request.JSONP

### success 

(*Function*) - callback to execute when the data returns.

### Signature

    onSuccess(resp)

#### Arguments:

- resp (*object*) - the response received from YQL proxy service.

   ex: Object { query=Object, more...} 


### complete

(*Function*) - callback to execute when the data returns.

### Signature:

    onComplete(resp)

#### Arguments:

- resp (*object*) - the response received from YQL proxy service.

   ex: Object { query=Object, more...} 


### request

(*Function*) - fired when you make a request.

### Signature:

    onRequest(script)

#### Arguments:

- script (*object*) - the HTMLScriptElement

  ex: &lt;script type="text/javascript" src="http://query.yahooapis.com/v1/public/yql?q=use%20'http%3A%2F%2Fthinkphp.ro%2Fapps%2FYQL%2Fslideshare.rss.xml'%20as%20s%3Bselect%20*%20from%20s%20where%20user%3D%22stoyan%22%20and%20amount%3D%2210%22&callback=Request.JSONP.request_map.request_0&format=xml&diagnostics=true"&gt;


Request.Slideshare Method: send(#Request.Slideshare:send)
---------------------------------------------------------

Executes a JSON request.

### Syntax:

    myreq.send([options]);

#### Arguments: 

- options (*Object*, optional) - key/value options that configure the request. Note: all options you know from Request.JSONP.     

### Returns:

- (*Object*) This instance of Request.Slideshare.

## Element Method: loadSlideshare

Updates the content of an Element with the desired badge Slideshare 

### Syntax:

    myElem.loadSlideshare(username, amount);

#### Arguments: 

1. username (*String*) - the username Slideshare.com you want.
2. amount (*integer*) - number of slides you want from user.

### Returns:

(*Element*) - the target Element.

### Example: 

    #html
    <div id="mywidget"></div>
 
    #js 
    $('mywidget').loadSlideshare('stoyan', 10);

