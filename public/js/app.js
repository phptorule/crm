(function () {
    'use strict';

    angular.module('app', ['ngRoute', 'ngAnimate', 'ui.bootstrap', 'ngFileUpload', 'ngSanitize']);
})();

;

(function () {
    'use strict';

    angular.module('app').config(['$routeProvider', '$locationProvider', function($routeProvider, $locationProvider) {
        var routes, setRoutes;
        $locationProvider.html5Mode({
            enabled: true,
            requireBase: false
        });

        var routes = [
            ':folder/:file/:param',
            ':folder/:file/',
            ':file'
        ];

        setRoutes = function(route) {
            var url = '/' + route;
            var config = {
                templateUrl: function(params) {
                    if (params.folder && params.file && params.param)
                    {
                        return '/view/' + params.folder + '/' + params.file + '/' + params.param;
                    }
                    else if (params.folder && params.file)
                    {
                        return '/view/' + params.folder + '/' + params.file;
                    }
                    else if(params.file)
                    {
                        return '/view/' + params.file;
                    }
                }
            };

            $routeProvider.when(url, config);
            return $routeProvider;
        };

        routes.forEach(function(route) {
            return setRoutes(route);
        });

        $routeProvider.when('/', {templateUrl: '/view/dashboard'});
    }]);
})();

;

(function () {
    'use strict';

    angular.module('app').controller('AppCtrl', [ '$scope', '$rootScope', '$uibModal', '$window', '$timeout', '$location', 'request', 'plugins', AppCtrl]);

    function AppCtrl($scope, $rootScope, $uibModal, $window, $timeout, $location, request, plugins) {
        $rootScope.token = '';
        $rootScope.body_class = '';
        $rootScope.open = 1;

        $scope.openSidebar = function() {
            $rootScope.open = 1 - $rootScope.open;
        };

        $scope.token = function(token) {
            $rootScope.token = token;
            $scope.init();
        };

        $scope.switchTeam = function(user_id) {
            user_id = user_id || false;
            $scope.teams_id = [];

            request.send('/users/getTeams', {'user_id' : user_id}, function(data) {
                if (data)
                {
                    for (var k in data)
                    {
                        $scope.teams_id[k] = data[k].teams_id;
                    }
                }
            });

            var modalInstance = $uibModal.open({
                animation: true,
                templateUrl: 'SwitchTeam.html',
                controller: 'ModalSwitchTeamCtrl',
                resolve: {
                    items: function () {
                        return {
                            'teams_id' : $scope.teams_id
                        };
                    }
                }
            });

            modalInstance.result.then(function(response) {
                $scope.reloadData();
            }, function () {

            });
        };

        $scope.signout = function() {
            request.send('/auth/signout', {}, function(data) {
                if (data)
                {
                    $timeout(function() {
                        $window.location.href = "/";
                    }, 2000);
                }
            });
        };

        $rootScope.user = {};
        $scope.init = function() {
            request.send('/users/info', {}, function(data) {
                if (data)
                {
                   $rootScope.user = data;
                }
            });
        };

        $scope.activeSidebar = function(segment) {
            segment = segment || '';
            var path = $location.path().split('/');
            return path[1] == segment;
        };

        $scope.sidebar = plugins.sidebar();
        plugins.getSidebar();
    };
})();

;

(function () {
    'use strict';

    angular.module('app').controller('ModalSwitchTeamCtrl', ['$rootScope', '$scope', '$uibModalInstance', 'request', 'validate', 'logger', 'langs', 'items', ModalSwitchTeamCtrl]);

    function ModalSwitchTeamCtrl($rootScope, $scope, $uibModalInstance, request, validate, logger, langs, items) {
        console.log(items);
    };
})();

;

