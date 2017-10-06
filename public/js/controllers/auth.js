(function () {
    'use strict';

    angular.module('app').controller('AuthCtrl', ['$rootScope', '$scope', '$window', '$timeout', '$location', 'request', 'validate', 'langs', AuthCtrl]);

    function AuthCtrl($rootScope, $scope, $window, $timeout, $location, request, validate, langs) {
    	$rootScope.body_class = 'body-wide body-auth';
        $scope.auth = {'users_email': '',
    				   'password': ''};

		$scope.signin = function() {
			var error = 1;
			error *= validate.check($scope.form.users_email, 'Email');
			error *= validate.check($scope.form.password, 'Password');
			if (error)
			{
				$rootScope.request_sent = true;
				request.send('/auth/signin', $scope.auth, function(data) {
					if (data)
					{
						if (data.resend_letters == true)
						{
							$scope.visible = true;
						}
						else
						{
							$timeout(function() {
								$window.location.href = "/";
							}, 2000);
						}
					}
					else
					{
						$rootScope.request_sent = false;
					}
				});
			}
		};

		$scope.resend = function() {
			request.send('/auth/resend', $scope.auth, function(data) {

			});
			$timeout(function() {
				$scope.visible = false;
			}, 1000);
		};

        $scope.signup = function() {
			var error = 1;
			error *= validate.check($scope.form.users_email, 'Email');
			error *= validate.check($scope.form.password, 'Password');
			if (error)
			{
				$rootScope.request_sent = true;
				request.send('/auth/signup', $scope.auth, function(data) {
					if (data)
					{
						$timeout(function() {
							$window.location.href = "/";
						}, 2000);
					}
					else
					{
						$rootScope.request_sent = false;
					}
				});
			}
        };

		$scope.reset = function() {
			var post_mas = {users_email: $scope.users_email};
			var error = 1;
			error *= validate.check($scope.form.users_email, 'Email');
			if (error)
			{
				request.send('/auth/recovery', post_mas, function(data) {
					if (data)
					{
						$timeout(function() {
							$window.location.href = "/";
						}, 2000);
					}
				});
			}
		};

		$scope.accept = function() {
			var post_mas = {users_name: $scope.users_name};
			var url = $location.url();
			var arrUrl =  url.split('/');
			post_mas.url = arrUrl[arrUrl.length - 1];
			var error = 1;
			error *= validate.check($scope.form.users_name, 'User name');
			error *= validate.check($scope.form.checkbox1, 'Chek up');
			if (error)
			{
				request.send('/auth/accept', post_mas, function(data) {
					if (data)
					{
						$timeout(function() {
							$window.location.href = "/";
						}, 2000);
					}
				});
			}
		};

		$scope.invite = {};
		$scope.inviteAlert = '';
		$scope.getInvite = function() {
			var hash = $location.path().split('/')[3];
			request.send('/auth/invite', {'hash': hash}, function(data) {
				if (data)
				{
					$scope.invite = data;
					$scope.inviteAlert = langs.get('You was invited into the team :team. To continue working with this team enter you personal data and click on Confirm button', {'team': $scope.invite.team.teams_name});
					$scope.auth.users_email = $scope.invite.users_email;
					$scope.auth.users_name = $scope.invite.users_name;
				}
			});
		};

		$scope.confirm = function() {
			var error = 1;
			error *= validate.check($scope.form.users_email, 'Email');
			if ($scope.invite.users_active == '0')
			{
				error *= validate.check($scope.form.password, 'Password');
			}
			error *= validate.check($scope.form.users_name, 'Username');
			if (error)
			{
				$scope.auth.users_id = $scope.invite.users_id;
				$scope.auth.teams_id = $scope.invite.team.teams_id;
				request.send('/auth/confirm', $scope.auth, function(data) {
					if (data)
					{
						$timeout(function() {
							$window.location.href = "/";
						}, 2000);
					}
				});
			}
		};
    };
})();

;