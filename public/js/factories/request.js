(function () {
    'use strict';

    angular.module('app').factory('request', ['$http', '$rootScope', 'Upload', 'logger', request]);

    function request($http, $rootScope, Upload, logger) {

    	return {
    		send: function(adrress, post_mas, callback, method) {
    			callback = callback || false;
    			method = method || 'post';

    			post_mas._token = $rootScope.token;
    			post_mas._method = method;

    			$http.post('/api' + adrress, post_mas).then(function(response) {
    				var data = logger.check(response.data);
    				if (callback)
					{
						(callback)(data);
					}
    			});
    		},

            sendWithFiles: function(adrress, post_mas, callback, percentsCallback, method) {
                callback = callback || false;
                percentsCallback = percentsCallback || false;
                method = method || 'post';

                post_mas._token = $rootScope.token;
                post_mas._method = method;

                Upload.upload({
                    url: ('/api' + adrress),
                    data: post_mas
                }).then(function (response) {
                    var data = logger.check(response.data);
                    if (callback)
                    {
                        (callback)(data);
                    }
                }, function (response) {
                    
                }, function (event) {
                    var progress = parseInt(100.0 * event.loaded / event.total);
                    if (percentsCallback)
                    {
                        (percentsCallback)(progress);
                    }
                });
            }
    	};
    };
})();

;