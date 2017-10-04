(function () {
    'use strict';

    angular.module('app').controller('UsersCtrl', ['$rootScope', '$scope', 'request', UsersCtrl]);

    function UsersCtrl($rootScope, $scope, request) {
        $scope.profile = $rootScope.user;

    	$scope.saveProfile = function() {
            console.log($scope.profile);
			request.sendWithFiles('/users/profile', $scope.profile, function(data) {
				if (data)
				{
					$rootScope.user = data;
				}
			});
		};
    };
})();

;