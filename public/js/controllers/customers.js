(function () {
    'use strict';

    angular.module('app').controller('CustomersCtrl', ['$rootScope', '$scope', '$uibModal', '$filter', 'request', 'validate', 'logger', 'langs', 'plugins', CustomersCtrl]);

    function CustomersCtrl($rootScope, $scope, $uibModal, $filter, request, validate, logger, langs, plugins) {
        $scope.currentTeam = {};
        $scope.customers = [];
        $scope.customers.customer_type = '0';
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
                console.log('1 error');
                $scope.customers.teams_id = $scope.team.teams_id;
                $scope.customers.contact_person = $scope.contact_person;
                $scope.customers.customer_type = $scope.customer_type;
                $scope.customers.assign_to = $scope.assign_to;
                $scope.customers.phone_number = $scope.phone_number;
                $scope.customers.external_phone_number = $scope.external_phone_number;
                $scope.customers.nip = $scope.nip;
                $scope.customers.email = $scope.email;
                $scope.customers.extra_email = $scope.extra_email;
                $scope.customers.website = $scope.website;
                $scope.customers.fb_link = $scope.fb_link;
                $scope.customers.invoice_street = $scope.invoice_street;
                $scope.customers.invoice_mailbox = $scope.invoice_mailbox;
                $scope.customers.invoice_town = $scope.invoice_town;
                $scope.customers.invoice_province = $scope.invoice_province ;
                $scope.customers.invoice_post_code = $scope.invoice_post_code;
                $scope.customers.invoice_region = $scope.invoice_region;
                $scope.customers.send_street = $scope.send_street;
                $scope.customers.send_mailbox = $scope.send_mailbox;
                $scope.customers.send_town = $scope.send_town;
                $scope.customers.send_province = $scope.send_province;
                $scope.customers.send_post_code = $scope.send_post_code;
                $scope.customers.send_region = $scope.send_region;
				request.send('/customers/save', $scope.customers, function(data) {

				});
			}
		};
    };
})();