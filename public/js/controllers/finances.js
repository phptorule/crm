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
		$scope.products_currency = '0';
        $scope.discount_window = [];
		$scope.discount_window[0] = false;
		$scope.discount_sum_window = false;
        $scope.vat_window = [];
        $scope.vat_window[0] = false;
        $scope.vat_sum_window = false;
    	$scope.products.products_discount_percent = 0;
    	$scope.products.products_discount_regular = 0;
    	$scope.products.products_amount = 1;
        $scope.products.products_cost = '';
        $scope.products.products_vat_percent = 0;
        $scope.discount_radio = [];
        $scope.discount_radio[0] = 'without';
        $scope.finances_payment_method = '0';
        $scope.finances_paid = '0';
        $scope.products.products_type = '0';
        $scope.products.products_vat_shipping_percent = 4.5;
        $scope.finances.products_ids = [];
        $scope.finances_id = $location.path().split('/')[3];
        $scope.products.cost_netto = 0;
        $scope.products.discount_amount = 0;
        $scope.products.cost_with_discount = 0;
        $scope.products.products_total_cost = 0;
        $scope.products.products_vat_amount = 0;
        $scope.products.tax_amount = 0;
        $scope.products.vat_shipping_amount = 0;
        $scope.products.products_shipping_price = 0;
        $scope.productsList = [];
        $scope.productsList.push($scope.products);

		$scope.init = function() {
			if ( ! $rootScope.user.users_id) {
				$rootScope.queue.push($scope.defaultUser);
			} else {
				$scope.getTeamUsers();
			}

            if ($scope.finances_id)
            {
                request.send('/finances/get', {'finances_id': $scope.finances_id}, function(data) {
                    console.log(data);
                    $scope.finances = data;
                    $scope.productsList = data.products;
                });

                for (var k in $scope.productsList)
                {
                    $scope.getProductCost(k);
                }
            }

            $scope.getFinancesNumber();
		};

        $scope.initList = function(data) {
            request.send('/finances/getList', {}, function(data) {
                console.log(data);
                $scope.pagesList = data;
            });
        };

        $scope.initRegisteredList = function() {
            request.send('/finances/getRegisteredList', {}, function(data) {
                $scope.pagesList = data;
            });
        };

        $scope.getFinancesNumber = function() {
            request.send('/finances/getFinancesNumber', {}, function(data) {
                $scope.finances_number = data;
            });
        };

        $scope.editFinances = function(block) {
            if (block == 'general')
            {
                $scope.edit_general = true;
            }

            if (block == 'address')
            {
                $scope.edit_address = true;
            }

            if (block == 'products')
            {
                $scope.edit_products = true;
            }

            $scope.old_finances = angular.copy($scope.finances);
            $scope.old_products = angular.copy($scope.products);
        };

        $scope.cancelEdit = function(block) {
            if (block == 'general')
            {
                $scope.edit_general = false;

            }

            if (block == 'address')
            {
                $scope.edit_address = false;
            }

            if (block == 'products')
            {
                $scope.edit_products = false;
            }

            $scope.finances = angular.copy($scope.old_finances);
            $scope.products = angular.copy($scope.old_products);
            delete $scope.old_finances;
            delete $scope.old_products;
        };

		$scope.getTeamUsers = function() {
            request.send('/users/getTeamUsers', {}, function(data) {
                $scope.team_users = data;
				$scope.users = [];

                for (var k in $scope.team_users)
                {
                    if ($scope.team_users[k].users_id == $rootScope.user.users_id)
                    {
                        $scope.finances.finances_assign_to = $rootScope.user.users_id.toString();
                    }
                }
            });
        };

        $scope.copyInvoiceAddress = function() {
        	$scope.finances.finances_send_street = $scope.finances.finances_invoice_street;
        	$scope.finances.finances_send_mailbox = $scope.finances.finances_invoice_mailbox;
        	$scope.finances.finances_send_town = $scope.finances.finances_invoice_town;
        	$scope.finances.finances_send_province = $scope.finances.finances_invoice_province;
        	$scope.finances.finances_send_post_code = $scope.finances.finances_invoice_post_code;
        	$scope.finances.finances_send_region = $scope.finances.finances_invoice_region;
        };

        $scope.copySendAddress = function() {
        	$scope.finances.finances_invoice_street = $scope.finances.finances_send_street;
        	$scope.finances.finances_invoice_mailbox = $scope.finances.finances_send_mailbox;
        	$scope.finances.finances_invoice_town = $scope.finances.finances_send_town;
        	$scope.finances.finances_invoice_province = $scope.finances.finances_send_province;
        	$scope.finances.finances_invoice_post_code = $scope.finances.finances_send_post_code;
        	$scope.finances.finances_invoice_region = $scope.finances.finances_send_region;
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
                //$scope.finances = response;
                $scope.finances.finances_invoice_street = response.invoice_street;
                $scope.finances.finances_invoice_mailbox = response.invoice_mailbox;
                $scope.finances.finances_invoice_town = response.invoice_town;
                $scope.finances.finances_invoice_province = response.invoice_province;
                $scope.finances.finances_invoice_post_code = response.invoice_post_code;
                $scope.finances.finances_invoice_region = response.invoice_region;
                $scope.finances.finances_send_street = response.send_street;
                $scope.finances.finances_send_mailbox = response.send_mailbox;
                $scope.finances.finances_send_town = response.send_town;
                $scope.finances.finances_send_province = response.send_province;
                $scope.finances.finances_send_post_code = response.send_post_code;
                $scope.finances.finances_send_region = response.send_region;
                $scope.finances.finances_customer_name = response.company_name;
            	$scope.getTeamUsers();
            }, function () {

            });
        };

        $scope.saveProduct = function() {
	    	var error = 1;
			error *= validate.check($scope.form.finances_customer_name, 'Klient');
			error *= validate.check($scope.form.finances_invoice_street, 'Ulica (do faktury)');
			error *= validate.check($scope.form.finances_send_street, 'Ulica (do wysylki)');
            for (var k in $scope.productsList)
            {
                console.log(k);
                error *= validate.check($scope.form_products['product_name_' + k], 'Nazwa pozycji');
                error *= validate.check($scope.form_products['product_cost_' + k], 'Cena');
            }

			if (error)
			{
                for (var k in $scope.productsList)
                {
                    $scope.productsList[k].products_currency = $scope.products_currency;
                }
                request.send('/finances/saveProduct', $scope.productsList, function(data) {
                    $scope.save(data);
                });
			}
		};

        $scope.save = function(products_ids) {
            $scope.finances.products_ids = products_ids;
            $scope.finances.finances_payment_method = $scope.finances_payment_method;
            $scope.finances.finances_paid = $scope.finances_paid;
            $scope.finances.finances_issue_date = $scope.finances_issue_date;
            $scope.finances.finances_payment_date = $scope.finances_payment_date;
            $scope.finances.finances_number = $scope.finances_number;
            request.send('/finances/save', $scope.finances, function(data) {
                if (data)
                {
                    $timeout(function() {
                        $window.location.href = "/finances/list/";
                    }, 1000);
                }
            });
        };

        $scope.registerFinance = function() {
            var error = 1;
            error *= validate.check($scope.form.finances_customer_name, 'Klient');
            error *= validate.check($scope.form.registered_finances_number, 'Numer faktury');
            error *= validate.check($scope.form.registered_subject, 'Temat');

            if (error)
            {
                $scope.finances.registered_customer_name = $scope.finances.finances_customer_name;
                $scope.finances.registered_payment_method = $scope.finances_payment_method;
                $scope.finances.registered_paid = $scope.finances_paid;
                $scope.finances.registered_issue_date = $scope.finances_issue_date;
                $scope.finances.registered_payment_date = $scope.finances_payment_date;
                $scope.finances.registered_assign_to = $scope.finances.finances_assign_to;

                request.send('/finances/registerFinance', $scope.finances, function(data) {
                    if (data)
                    {
                        console.log(data);
                        /*$timeout(function() {
                            $window.location.href = "/finances/registered_list/";
                        }, 1000);*/
                    }
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
			$scope.finances_issue_date = new Date();
			$scope.finances_payment_date = new Date();
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

        $scope.notFloat = function(e) {
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        };

        $scope.addProduct = function() {
            $scope.object = angular.copy($scope.products);
            $scope.object.products_name = '';
            $scope.object.products_cost = '';
            $scope.object.products_discount_percent = 0;
            $scope.object.products_discount_regular = 0;
            $scope.object.products_vat_percent = 0;
            $scope.object.cost_netto = 0;
            $scope.object.discount_amount = 0;
            $scope.object.cost_with_discount = 0;
            $scope.object.products_vat_amount = 0;
            $scope.object.products_total_cost = 0;
            $scope.object.products_dimension = '';

            $scope.productsList.push($scope.object);
        };

        $scope.openDiscount = function(index) {
            $scope.discount_window[index] = ! $scope.discount_window[index];
            $scope.vat_window[index] = false;
        };

        $scope.openTax = function(index) {
            $scope.vat_window[index] = ! $scope.vat_window[index];
            $scope.discount_window[index] = false;
        };

        $scope.setDiscount = function(index, discount) {
        	if (discount == 'without')
    		{
    			$scope.productsList[index].products_discount_percent = 0;
    			$scope.productsList[index].products_discount_regular = 0;
                $scope.productsList[index].discount_amount = 0;
                $scope.productsList[index].cost_with_discount = 0;
                $scope.productsList[index].products_vat_amount = ($scope.productsList[index].cost_netto * $scope.productsList[index].products_vat_percent) / 100;
                $scope.productsList[index].products_total_cost = $scope.productsList[index].cost_netto + $scope.productsList[index].products_vat_amount;
    		}

    		if (discount == 'percent')
    		{
    			$scope.productsList[index].products_discount_regular = 0;
                $scope.productsList[index].discount_amount = 0;
                $scope.productsList[index].cost_with_discount = 0;
                $scope.productsList[index].products_vat_amount = ($scope.productsList[index].cost_netto * $scope.productsList[index].products_vat_percent) / 100;
                $scope.productsList[index].products_total_cost = $scope.productsList[index].cost_netto + $scope.productsList[index].products_vat_amount;
    		}

    		if (discount == 'regular')
    		{
    			$scope.productsList[index].products_discount_percent = 0;
                $scope.productsList[index].discount_amount = 0;
                $scope.productsList[index].cost_with_discount = 0;
                $scope.productsList[index].products_vat_amount = ($scope.productsList[index].cost_netto * $scope.productsList[index].products_vat_percent) / 100;
                $scope.productsList[index].products_total_cost = $scope.productsList[index].cost_netto + $scope.productsList[index].products_vat_amount;
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

        $scope.getProductCost = function(index) {
            if ( ! $scope.productsList[index].products_amount || ! $scope.productsList[index].products_cost)
            {
                $scope.productsList[index].cost_netto = 0;
                var total_cost = $scope.productsList[index].cost_netto;
            }
            else
            {
                $scope.productsList[index].products_cost = $scope.productsList[index].products_cost.replace(/,/g,'.');
                $scope.productsList[index].cost_netto = $scope.productsList[index].products_amount * $scope.productsList[index].products_cost;
                var total_cost = $scope.productsList[index].cost_netto;
            }

            if ($scope.productsList[index].products_vat_percent)
            {
                $scope.productsList[index].products_vat_percent = $scope.productsList[index].products_vat_percent.replace(/,/g,'.');
                $scope.productsList[index].products_vat_amount = ($scope.productsList[index].cost_netto * $scope.productsList[index].products_vat_percent) / 100;
                var total_cost = $scope.productsList[index].cost_netto + $scope.productsList[index].products_vat_amount;
            }

            if ($scope.productsList[index].products_discount_percent == 0 && $scope.productsList[index].products_discount_regular == 0)
            {
                $scope.productsList[index].discount_amount = 0;
            }

            if ($scope.productsList[index].products_discount_percent != 0)
            {
                $scope.productsList[index].products_discount_percent = $scope.productsList[index].products_discount_percent.replace(/,/g,'.');
                $scope.productsList[index].discount_amount = ($scope.productsList[index].cost_netto * $scope.productsList[index].products_discount_percent / 100)*1;
                $scope.productsList[index].cost_with_discount = $scope.productsList[index].cost_netto - $scope.productsList[index].discount_amount;
                var total_cost = $scope.productsList[index].cost_with_discount;
            }

            if ($scope.productsList[index].products_discount_regular != 0)
            {
                $scope.productsList[index].products_discount_regular = $scope.productsList[index].products_discount_regular.replace(/,/g,'.');
                $scope.productsList[index].discount_amount = $scope.productsList[index].products_discount_regular*1;
                $scope.productsList[index].cost_with_discount = $scope.productsList[index].cost_netto - $scope.productsList[index].discount_amount;
                var total_cost = $scope.productsList[index].cost_with_discount;
            }

            if ($scope.productsList[index].products_vat_percent)
            {
                $scope.productsList[index].products_vat_percent = $scope.productsList[index].products_vat_percent.replace(/,/g,'.');
                $scope.productsList[index].products_vat_amount = ($scope.productsList[index].cost_with_discount * $scope.productsList[index].products_vat_percent) / 100;
                var total_cost = $scope.productsList[index].cost_with_discount + $scope.productsList[index].products_vat_amount;
            }

            if ($scope.productsList[index].cost_with_discount)
            {
                var product_price = $scope.productsList[index].cost_with_discount;
            }
            else
            {
                var product_price = $scope.productsList[index].cost_netto;
            }

            if ($scope.productsList[index].products_vat_percent == 0)
            {
                $scope.productsList[index].products_vat_amount = 0;
                var total_cost = product_price + $scope.productsList[index].products_vat_amount;
            }
            else
            {
                $scope.productsList[index].products_vat_percent = $scope.productsList[index].products_vat_percent.replace(/,/g,'.');
                $scope.productsList[index].products_vat_amount = (product_price * $scope.productsList[index].products_vat_percent) / 100;
                var total_cost = product_price + $scope.productsList[index].products_vat_amount;
            }

            $scope.productsList[index].products_total_cost = total_cost;
        };

        $scope.getTotalAmount = function(product_cost) {
            $scope.products.products_total_amount = 0;
            for (var k in $scope.productsList)
            {
                if ($scope.productsList[k].products_total_cost != undefined)
                {
                    $scope.products.products_total_amount += $scope.productsList[k].products_total_cost;
                }
            }

            return $scope.products.products_total_amount;
        };

        $scope.getShippingTax = function() {
            if ($scope.products.products_total_amount)
            {
                var products_total_amount = $scope.products.products_total_amount;
            }
            else
            {
                var products_total_amount = 0;
            }

            if ( ! $scope.products.products_shipping_price)
            {
                $scope.finances.finances_total_amount = products_total_amount;
            }
            else
            {
                $scope.products.products_shipping_price = $scope.products.products_shipping_price.replace(/,/g,'.');
                $scope.products.vat_shipping_amount = ($scope.products.products_shipping_price * $scope.products.products_vat_shipping_percent) / 100;
                $scope.finances.finances_total_amount = $scope.products.vat_shipping_amount + products_total_amount;
            }

            return $scope.finances.finances_total_amount;
        };

	    /* Setting page titles */
	    if ($location.path() == '/finances/list/')
        {
            Page.setTitle('Wystawione faktury');
            Page.setIcon('fa fa-th-list');
        }

	    if ($location.path() == '/finances/add/')
	    {
	        Page.setTitle('Wystaw fakturę');
	        Page.setIcon('fa fa-plus');
	    }

        if ($location.path() == '/finances/register/')
        {
            Page.setTitle('Zarejestruj fakturę');
            Page.setIcon('fa fa-plus');
        }

        if ($location.path() == '/finances/registered_list/')
        {
            Page.setTitle('Zarejestrowane faktury');
            Page.setIcon('fa fa-th-list');
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
            	$scope.customers = data;
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