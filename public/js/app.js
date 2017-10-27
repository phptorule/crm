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

(function() {
    'use strict';

    angular.module('app').factory('Page', [Page]);

    function Page() {
        var title = 'CRM';
        var icon = 'fa fa-dashboard';
        return {
            title: function() {
                return title;
            },
            setTitle: function(newTitle) {
                title = newTitle;
            },
            icon: function() {
                return icon;
            },
            setIcon: function(newIcon) {
                icon = newIcon;
            }
        };
    };
})();

(function () {
    'use strict';

    angular.module('app').controller('AppCtrl', [ '$scope', '$rootScope', '$uibModal', '$window', '$timeout', '$location', 'request', 'plugins', 'Page', AppCtrl]);

    function AppCtrl($scope, $rootScope, $uibModal, $window, $timeout, $location, request, plugins, Page) {
        $rootScope.token = '';
        $rootScope.body_class = '';
        $rootScope.open = 1;
        $scope.Page = Page;
        $rootScope.user = {};
        $rootScope.queue = [];

        $scope.openSidebar = function() {
            $rootScope.open = 1 - $rootScope.open;
        };

        $scope.token = function(token) {
            $rootScope.token = token;
            $scope.init();
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

        $scope.init = function() {
            request.send('/users/info', {}, function(data) {
                if (data)
                {
                    $rootScope.user = data;
                    for (var k in $rootScope.queue)
                    {
                        $rootScope.queue[k]();
                    }
                }
            });

            request.send('/users/getCurrentTeam', {}, function(data) {
                if (data)
                {
                   $rootScope.current_team = data;
                }
            });
        };

        $scope.activeSidebar = function(segment) {
            segment = segment || '';
            var path = $location.path().split('/');
            return path[1] == segment;
        };

        $scope.initLobipanel = function() {
            $('.lobidrag').lobiPanel({
                sortable: true,
                editTitle: false,
                unpin: false,
                reload: false,
                minimize: {
                    icon: 'ti-minus',
                    icon2: 'ti-plus'
                },
                close: false,
                expand: {
                    icon: 'ti-fullscreen',
                    icon2: 'ti-fullscreen'
                }
            });

            $('.lobidisable').lobiPanel({
                reload: false,
                close: false,
                editTitle: false,
                sortable: true,
                unpin: false,
                minimize: {
                    icon: 'ti-minus',
                    icon2: 'ti-plus'
                },
                expand: {
                    icon: 'ti-fullscreen',
                    icon2: 'ti-fullscreen'
                }
            });
        };

        $scope.initIcheck = function() {
            $('.i-check input').iCheck({
                 radioClass: 'iradio_square-blue'
            });
        };

        $scope.getClass = function (path) {
            if ( ! $location.path().split('/')[3])
            {
                return ($location.path().substr(0, path.length) === path) ? 'active' : '';
            }
        }

        $scope.sidebar = plugins.sidebar();
        plugins.getSidebar();

        $scope.$on('$viewContentLoaded', function(){
            $scope.initLobipanel();
            $scope.initIcheck();
        });
    };
})();

;

