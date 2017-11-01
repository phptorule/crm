(function () {
    'use strict';

    angular.module('app').controller('FinancesCtrl', ['$rootScope', '$scope', '$uibModal', '$filter', '$location', '$timeout', '$window', 'request', 'validate', 'logger', 'langs', 'plugins', 'Page', FinancesCtrl]);

    function FinancesCtrl($rootScope, $scope, $uibModal, $filter, $location, $timeout, $window, request, validate, logger, langs, plugins, Page) {
    	$scope.types_list = ['By Month', 'By Year', 'Custom Period'];
		$scope.months_list = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        $scope.list = [];
        $scope.listFiltered = [];
        $scope.pagesList = [];
        $scope.numPerPage = 20;
        $scope.currentPage = 1;
		$scope.team_users = [];
		$scope.finances = {};
		$scope.products = {};
		$scope.products.products_currency = '0';
		$scope.discount_window = false;
		$scope.discount_sum_window = false;
        $scope.vat_window = false;
        $scope.vat_sum_window = false;
    	$scope.discount_percent = 0;
    	$scope.discount_regular = 0;
    	$scope.products.products_amount = 1;
        $scope.products.products_cost = 0;
        $scope.products.products_vat_percent = 0;
        $scope.discount_radio = 'without';
        $scope.pay_type = '0';
        $scope.invoice_paid = '0';
        $scope.products.products_type = '0';
        $scope.products.vat_shipping_percent = 4.5;
        $scope.products.products_ids = '';
        $scope.finances_id = $location.path().split('/')[3];

		$scope.init = function(data) {
			if ( ! $rootScope.user.users_id) {
				$rootScope.queue.push($scope.defaultUser);
			} else {
				$scope.getTeamUsers();
			}
		};

        $scope.initList = function(data) {
            request.send('/finances/getList', {}, function(data) {
                $scope.print(data);
            });
        };

        $scope.print = function(data) {
            $scope.list = data;
            $scope.listFiltered = $scope.list;
            $scope.order('-created_at');
        };

        $scope.order = function(rowName) {
            $scope.row = rowName;
            $scope.listFiltered = $filter('orderBy')($scope.list, rowName);

            $scope.changePage(1);
            return $scope.currentPage = 1;
        };

        $scope.changePage = function(page) {
            var end, start;
            start = (page - 1) * $scope.numPerPage;
            end = start + $scope.numPerPage;
            //return $scope.pagesList = $scope.listFiltered.slice(start, end);
            return $scope.pagesList = $scope.listFiltered;
        };

		$scope.getTeamUsers = function() {
            request.send('/users/getTeamUsers', {}, function(data) {
                $scope.team_users = data;
				$scope.users = [];

                for (var k in $scope.team_users)
                {
                    if ($scope.team_users[k].users_id == $rootScope.user.users_id)
                    {
                        $scope.finances.assign_to = $rootScope.user.users_id.toString();
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
			error *= validate.check($scope.form_products.products_ids, 'At least one product');
			if (error)
			{
                $scope.finances.pay_type = $scope.pay_type;
                $scope.finances.invoice_paid = $scope.invoice_paid;
                $scope.finances.issue_date = $scope.issue_date;
                $scope.finances.payment_date = $scope.payment_date;
                console.log($scope.finances);
                request.send('/finances/save', $scope.finances, function(data) {
                    $timeout(function() {
                        $window.location.href = "/finances/list/";
                    }, 1000);
                });
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
			$scope.issue_date = new Date();
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
        	if (discount == 'without')
    		{
    			$scope.discount_percent = 0;
    			$scope.discount_regular = 0;
    		}

    		if (discount == 'percent')
    		{
    			$scope.discount_regular = 0;
    		}

    		if (discount == 'regular')
    		{
    			$scope.discount_percent = 0;
    		}
        };

        $scope.setSumDiscount = function(discount) {
        	if (discount == 'without')
    		{
    			$scope.discount_sum_percent = 0;
    			$scope.discount_sum_regular = 0;
    		}

    		if (discount == 'percent')
    		{
    			$scope.discount_sum_regular = 0;
    		}

    		if (discount == 'regular')
    		{
    			$scope.discount_sum_percent = 0;
    		}
        };

        $scope.getDiscount = function() {
        	var sumOfPercent = 0;

        	if ($scope.discount_percent == 0 && $scope.discount_regular == 0)
        	{
        		return 0;
        	}

        	if ($scope.discount_percent != 0)
        	{
        		sumOfPercent = $scope.getSumNetto() - $scope.getSumWithDiscount();
        		return (sumOfPercent).toFixed(2);
        	}

        	if ($scope.discount_regular != 0)
        	{
        		return $scope.discount_regular;
        	}
        };

        $scope.getSumWithDiscount = function() {
        	var nettoSum = 0;
	    	var discountNettoSum = 0;

	    	if ($scope.discount_percent != 0)
	    	{
	    		nettoSum = $scope.getSumNetto();
				discountNettoSum = nettoSum * ((100 - $scope.discount_percent) / 100);
	    	}
	    	else
	    	{
	    		nettoSum = $scope.getSumNetto();
				discountNettoSum = nettoSum - $scope.discount_regular;
            }
			return discountNettoSum.toFixed(2);
        };

        $scope.getSumNetto = function() {
        	if ( ! $scope.products.products_amount || ! $scope.products.products_cost)
    		{
    			return 0;
    		}
    		else
    		{
    			return ($scope.products.products_amount * $scope.products.products_cost).toFixed(2);
    		}
        };

        $scope.getTax = function() {
        	var sumWithDiscount = $scope.getSumWithDiscount();

        	if ($scope.products.products_vat_percent == 0)
        	{
        		$scope.products.products_vat_amount = 0;
        	}

        	if (sumWithDiscount)
        	{
        		$scope.products.products_vat_amount = ((sumWithDiscount * $scope.products.products_vat_percent) / 100).toFixed(2);

            }
        		return $scope.products.products_vat_amount;
        };

        $scope.getSumBrutto = function() {
        	if ($scope.getSumWithDiscount() == 0 && $scope.getTax() == 0)
        	{
        		return 0;
        	}

        	if ($scope.getSumWithDiscount() && $scope.getTax() == 0)
        	{
                $scope.products.products_total_cost = $scope.getSumWithDiscount();

                return $scope.products.products_total_cost;
        	}

        	if ($scope.getTax())
        	{
                $scope.products.products_total_cost = ($scope.getTax()*1 + $scope.getSumWithDiscount()*1).toFixed(2);

                return $scope.products.products_total_cost;
        	}
        };

        $scope.getShippingTax = function() {
            if ( ! $scope.products.shipping_price)
            {
                return 0;
            }
            else
            {
                $scope.products.vat_shipping_amount = (($scope.products.shipping_price * $scope.products.vat_shipping_percent) / 100).toFixed(2);

                return $scope.products.vat_shipping_amount;
            }
        };

        $scope.getTotalCost = function() {
            if ( ! $scope.products.shipping_price)
            {
                return $scope.getSumBrutto();
            }
            else
            {
                return ($scope.getSumBrutto()*1 + $scope.getShippingTax()*1 + $scope.products.shipping_price*1).toFixed(2);
            }
        };

        $scope.saveProduct = function() {
            var error = 1;

            error *= validate.check($scope.form_products.product_name, 'Nazwa pozycji');

            if ($scope.products.products_type == 0)
            {
                error *= validate.check($scope.form_products.product_amount, 'Ilosc');
            }

            error *= validate.check($scope.form_products.product_cost, 'Cena');

            if (error)
            {
                request.send('/finances/saveProduct', $scope.products, function(data) {
                    $scope.finances.products_ids = data;
                });
            }

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