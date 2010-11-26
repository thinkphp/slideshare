var SlideShare = new Class({
             Extends: Request.JSONP,
             options: {
                     url: 'http://query.yahooapis.com/v1/public/yql?q=use%20%22http%3A%2F%2Fthinkphp.ro%2Fapps%2Fslideshare%2FRequest.Slideshare%2Fslideshare.table.xml%22%20as%20slideshare%3B%20select%20*%20from%20slideshare%20where%20username%3D%22{username}%22',
                     data: {
                        format: 'json'
                     }
             },
             initialize: function(username,options,badgeID) {
                     this.options.url = this.options.url.substitute({username: username});  
                     this.parent(options);
                     this.badgeID = badgeID; 
             }                
}); 