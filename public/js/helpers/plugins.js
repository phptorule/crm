(function () {
    'use strict';

    angular.module('app').factory('plugins', ['$q', 'request', plugins]);

    function plugins($q, request) {
        var factory = {};
        factory.sidebar = {};

    	factory.list = function(refresh) {
            refresh = refresh || false;
            
            var deferred = $q.defer();
            if ( ! factory.plugins || refresh)
            {
                request.send('/plugins/get', {}, function(data) {
                    if (data)
                    {
                        factory.plugins = data;
                        return deferred.resolve(factory.plugins);
                    }
                }, 'GET');
            }
            else
            {
                deferred.resolve(factory.plugins);
            }
            return deferred.promise;
		};

        factory.getSidebar = function() {
            request.send('/plugins/forUser', {}, function(data) {
                if (data)
                {
                    factory.sidebar.plugins = data;
                }
            }, 'GET');
        };

        factory.sidebar = function() {
            return factory.sidebar || {};
        };

        factory.save = function(teams_id, plugins_id, plugins_active) {
            request.send('/plugins/save', {'teams_id': teams_id, 'plugins_id': plugins_id, 'plugins_active': plugins_active}, function(data) {
                if (data)
                {
                    factory.getSidebar();
                }
            });
        };

        return factory;
    };
})();

;