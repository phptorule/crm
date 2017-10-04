(function () {
    'use strict';

    angular.module('app').factory('langs', ['$http', langs]);

    function langs($http) {
        var list = {};
        $http.get('/api/langs/get').then(function(response) {
            list = response;
        });

        return {
            get: function(key, vars) {
                vars = vars || {};
                var text = key;
                for (var i in list) 
                {
                    if (i.toLowerCase() == key.toLowerCase() && list[i] != '')
                    {
                        text = list[i];
                    }
                }

                for (var i in vars) 
                {
                    text = text.replace(":" + i, vars[i]);
                }

                return text;
           }
        };
    };
})();

;