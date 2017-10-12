(function () {
    'use strict';

    angular.module('app').controller('CustomersCtrl', ['$rootScope', '$scope', '$uibModal', '$filter', 'request', 'validate', 'logger', 'langs', 'plugins', CustomersCtrl]);

    function CustomersCtrl($rootScope, $scope, $uibModal, $filter, request, validate, logger, langs, plugins) {
        $scope.currentTeam = {};
        $scope.customers.customer_type = 0;
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
			$scope.getCurrentTeam();
		};

        $scope.getCurrentTeam = function () {
            request.send('/users/getCurrentTeam', {}, function(data) {
                if (data)
                {
                   $scope.team = data[0];
                }
            });
        };

		$scope.save = function() {
	    	var error = 1;
			error *= validate.check($scope.form.company_name, 'Nazwa firmy');
			if (error)
			{
                $scope.customers.teams_id = $scope.team.teams_id;
                $scope.customers.customer_type = $scope.customer_type;
				request.send('/customers/save', $scope.customers, function(data) {

				});
			}
		};
    };
})();