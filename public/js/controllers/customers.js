(function () {
    'use strict';

    angular.module('app').controller('CustomersCtrl', ['$rootScope', '$scope', '$uibModal', '$filter', 'request', 'validate', 'logger', 'langs', 'plugins', CustomersCtrl]);

    function CustomersCtrl($rootScope, $scope, $uibModal, $filter, request, validate, logger, langs, plugins) {
    	$scope.teams = [];
        $scope.currentTeam = {};
        /*if (true)
        {
        	$scope.customers.contact_person = '';
        	$scope.customers.customer_type = 0;
        	$scope.customers.assign_to = '';
        	$scope.customers.phone_number = 0;
        	$scope.customers.external_phone_number = 0;
        	$scope.customers.nip = '';
        	$scope.customers.email = '';
        	$scope.customers.extra_email = '';
        	$scope.customers.website = '';
        	$scope.customers.fb_link = '';
        	$scope.customers.invoice_street = '';
        	$scope.customers.invoice_mailbox = '';
        	$scope.customers.invoice_town = '';
        	$scope.customers.invoice_province = '';
        	$scope.customers.invoice_post_code = '';
        	$scope.customers.invoice_region = '';
        	$scope.customers.send_street = '';
        	$scope.customers.send_mailbox = '';
        	$scope.customers.send_town = '';
        	$scope.customers.send_province = '';
        	$scope.customers.send_post_code = '';
        	$scope.customers.send_region = '';
        }*/

    	$scope.init = function() {
			$scope.getTeams();
		};

		$scope.getTeams = function() {
			request.send('/teams/getLeaderTeams', {}, function(data) {
				if (data)
				{
					$scope.teams = data;
					$scope.changeTeam($scope.teams[0].teams_id);
				}
			}, 'GET');
		};

		$scope.changeTeam = function(teams_id) {
			for (var k in $scope.teams)
			{
				if ($scope.teams[k].teams_id == teams_id)
				{
					$scope.currentTeam = $scope.teams[k];
				}
			}

			//$scope.reloadData();
		};

		$scope.save = function() {
	    	var error = 1;
			error *= validate.check($scope.form.company_name, 'Nazwa firmy');
			if (error)
			{
				console.log($scope.customers);
				request.send('/customers/save', $scope.customers, function(data) {

				});
			}
		};
    };
})();