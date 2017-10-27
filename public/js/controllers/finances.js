(function () {
    'use strict';

    angular.module('app').controller('FinancesCtrl', ['$rootScope', '$scope', '$uibModal', '$filter', '$location', '$timeout', '$window', 'request', 'validate', 'logger', 'langs', 'plugins', 'Page', FinancesCtrl]);

    function FinancesCtrl($rootScope, $scope, $uibModal, $filter, $location, $timeout, $window, request, validate, logger, langs, plugins, Page) {
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
		$scope.finances.currency = '0';
		$scope.discount_window = false;

		$scope.defaultUser = function() {
			$scope.finances.assign_to = $rootScope.user.user_id;
		};

		$scope.getUsersList = function() {
			var list = [];
			list.push($rootScope.user);

			return list;
		};

		$scope.init = function(data) {
			$scope.getTeamUsers();
			$scope.getUsersList();

			if ( ! $rootScope.user.users_id) {
				$rootScope.queue.push($scope.defaultUser);
			} else {
				$scope.defaultUser();
			}
		};

		$scope.getTeamUsers = function() {
            request.send('/users/getTeamUsers', {}, function(data) {
                $scope.team_users = data;
				$scope.users = [];

                for (var k in $scope.team_users)
                {
                    if ($scope.inArray($scope.finances.users_ids, $scope.team_users[k].users_id))
                    {
                        $scope.users.push($scope.team_users[k]);
                    }
                }
            });
        };

        $scope.copyInvoiceAddress = function() {
        	$scope.finances.send_street = $scope.finances.invoice_street;
        	$scope.finances.send_mailbox = $scope.finances.invoice_mailbox;
        	$scope.finances.send_town = $scope.finances.invoice_town;
        	$scope.finances.send_province = $scope.finances.invoice_province;
        	$scope.finances.send_post_code = $scope.finances.invoice_post_code;
        	$scope.finances.send_region = $scope.finances.invoice_region;
        };

        $scope.copySendAddress = function() {
        	$scope.finances.invoice_street = $scope.finances.send_street;
        	$scope.finances.invoice_mailbox = $scope.finances.send_mailbox;
        	$scope.finances.invoice_town = $scope.finances.send_town;
        	$scope.finances.invoice_province = $scope.finances.send_province;
        	$scope.finances.invoice_post_code = $scope.finances.send_post_code;
        	$scope.finances.invoice_region = $scope.finances.send_region;
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
            	$scope.getTeamUsers();
            }, function () {

            });
        };

        $scope.save = function(check) {
	    	var error = 1;
			error *= validate.check($scope.form.customer, 'Klient');
			error *= validate.check($scope.form.payment_date, 'Termin platności');
			error *= validate.check($scope.form.assign_to, 'Przypisany do');
			error *= validate.check($scope.form_address.invoice_street, 'Ulica (do faktury)');
			error *= validate.check($scope.form_address.send_street, 'Ulica (do wysylki)');
			error *= validate.check($scope.form_products.product_name, 'Nazwa pozycji');
			error *= validate.check($scope.form_products.product_count, 'Ilosc');
			error *= validate.check($scope.form_products.product_cost, 'Cena');
			if (error)
			{
				console.log($scope.form.assign_to);
			}
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

		$scope.inArray = function(list, value) {
            var result = false;

            for (var k in list)
            {
                if (list[k] == value)
                {
                    result = true;
                }
            }

            return result;
        };

        $scope.setDiscount = function(discount) {
        	if (discount == 'percent')
    		{
    			$scope.discount_radio = 'percent';
    		}

    		if (discount == 'without')
    		{
    			$scope.discount_radio = 'without';
    		}

    		if (discount == 'regular')
    		{
    			$scope.discount_radio = 'regular';
    		}


    		console.log($scope.discount_radio);
        };

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