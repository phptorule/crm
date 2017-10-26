(function () {
    'use strict';

    angular.module('app').controller('FinancesCtrl', ['$rootScope', '$scope', '$uibModal', '$filter', '$location', 'request', 'langs', 'Page', FinancesCtrl]);

    function FinancesCtrl($rootScope, $scope, $uibModal, $filter, $location, request, langs, Page) {
    	$scope.types_list = ['By Month', 'By Year', 'Custom Period'];
		$scope.months_list = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

		$scope.filter = {};
		$scope.filter.type = '0';
		$scope.filter.month = (new Date()).getMonth().toString();
		$scope.filter.year = (new Date()).getFullYear().toString();
		$scope.filter.payer = '';
		$scope.team_users = [];
		$scope.invoice_paid = '0';
		$scope.finances = {};

		$scope.init = function(data) {
			$scope.getTeamUsers();
		};

		$scope.getTeamUsers = function() {
            request.send('/users/getTeamUsers', {}, function(data) {
                $scope.team_users = data;
            });
        };

    	$scope.selectCustomer = function() {
            var modalInstance = $uibModal.open({
                animation: true,
                templateUrl: 'SelectCustomer.html',
                controller: 'ModalSelectCustomerCtrl',
                resolve: {
                    items: function () {
                        return true;
                    }
                }
            });

            modalInstance.result.then(function(response) {
            	$scope.finances = response;
            }, function () {

            });
        };

        $scope.dateOptions = {
			startingDay: 1,
			showWeeks: false
		};

		$scope.date = [{
		    opened: false
		}, {
		    opened: false
		}];

		$scope.calendarOpen = function(index) {
			$scope.date[index].opened = true;
		};

		$scope.setDate = function() {
			$scope.invoice_date = new Date();
			$scope.payment_date = new Date();
		};
		$scope.setDate();

	    /* Setting page titles */
	    if ($scope.customer_id)
	    {
	        Page.setTitle('Kontrahent');
	        Page.setIcon('fa fa-user');
	    }

	    if ($location.path() == '/finances/add/')
	    {
	        Page.setTitle('Wystaw fakturę');
	        Page.setIcon('fa fa-plus');
	    }
	};
})();

(function () {
    'use strict';

    angular.module('app').controller('ModalSelectCustomerCtrl', ['$rootScope', '$scope', '$uibModal', '$uibModalInstance', '$filter', 'request', 'validate', 'logger', 'langs', 'items', ModalSelectCustomerCtrl]);

    function ModalSelectCustomerCtrl($rootScope, $scope, $uibModal, $uibModalInstance, $filter, request, validate, logger, langs, items) {
    	$scope.filteredCustomers = [];
        $scope.customers = [];
        $scope.pagesList = [];
        $scope.numPerPage = 5;
        $scope.currentPage = 1;
        $scope.maxSize = 5;

    	$scope.initList = function() {
            request.send('/customers/getList', {}, function(data) {
            	//$scope.filteredCustomers = data;
            	$scope.pagination(data);
            });
        };

        $scope.numPages = function () {
		    return Math.ceil($scope.customers.length / $scope.numPerPage);
		};

		$scope.pagination = function(customers) {
			$scope.$watch('currentPage + numPerPage', function() {
			    var begin = (($scope.currentPage - 1) * $scope.numPerPage)
			    , end = begin + $scope.numPerPage;

			    $scope.filteredCustomers = customers.slice(begin, end);
		  	});
		};


	  	$scope.getCustomer = function(customer) {
	  		$uibModalInstance.close(customer);
	  	};

	  	$scope.addCustomer = function() {
	  		var modalInstance = $uibModal.open({
                animation: true,
                templateUrl: 'CreateCustomer.html',
                controller: 'ModalCreateCustomerCtrl',
                resolve: {
                    items: function () {
                        return true;
                    }
                }
            });

            modalInstance.result.then(function(response) {
            	$uibModalInstance.close(response);
            }, function () {

            });
	  	};

	  	$scope.cancel = function() {
            $uibModalInstance.dismiss('cancel');
        };
    };
})();

(function () {
    'use strict';

    angular.module('app').controller('ModalCreateCustomerCtrl', ['$rootScope', '$scope', '$uibModalInstance', '$filter', 'request', 'validate', 'logger', 'langs', 'items', ModalCreateCustomerCtrl]);

    function ModalCreateCustomerCtrl($rootScope, $scope, $uibModalInstance, $filter, request, validate, logger, langs, items) {
    	$scope.cancel = function() {
            $uibModalInstance.dismiss('cancel');
        };

        $scope.saveCustomer = function() {
        	var error = 1;
			error *= validate.check($scope.form.company_name, 'Nazwa firmy');
			if (error)
			{
	            request.send('/customers/save', $scope.customers, function(data) {
	                if (data)
	                {
	                    $scope.getCustomer(data);
	                }
	            });
        	}
        };

        $scope.getCustomer = function(customer_id) {
        	request.send('/customers/get', {'customer_id': customer_id}, function(data) {
                if (data)
                {
                	$uibModalInstance.close(data);
                }
            });
        };
    };
})();