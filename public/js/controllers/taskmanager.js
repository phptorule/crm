(function () {
    'use strict';

    angular.module('app').controller('Task_managerCtrl', ['$rootScope', '$scope', '$uibModal', '$filter', '$location', '$timeout', '$window', 'request', 'validate', 'logger', 'langs', 'plugins', 'Page', Task_managerCtrl]);

    function Task_managerCtrl($rootScope, $scope, $uibModal, $filter, $location, $timeout, $window, request, validate, logger, langs, plugins, Page) {
    	$scope.types_list = ['By Month', 'By Year', 'Custom Period'];
		$scope.months_list = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        //
        $scope.list = {};
        $scope.desl = [];
        //$scope.name_task_block;
        //
        //$scope.list = [];
        $scope.tasks = {};
        $scope.taskss = [];
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
        $scope.registered_id = $location.path().split('/')[3];
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
        $scope.class = "closed";


        $scope.initList = function(data) {
            request.send('/finances/getList', {}, function(data) {
                $scope.pagesList = data;
            });
        };

        $scope.initRegisteredList = function() {
            request.send('/finances/getRegisteredList', {}, function(data) {
                $scope.pagesList = data;
            });
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
                    if ($scope.finances_id)
                    {
                        $scope.edit_general = false;
                        $scope.edit_address = false;
                        $scope.edit_products = false;
                        $scope.init();
                    }
                    else
                    {
                        $timeout(function() {
                            $window.location.href = "/finances/add/" + data;
                        }, 1000);
                    }
                }
            });
        };



        $scope.getFinancesNumber = function() {
            request.send('/finances/getFinancesNumber', {}, function(data) {
                $scope.finances_number = data;
            });
        };



		$scope.initTeamUsers = function() {
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



        $scope.getTask = function() {

            request.send('/taskManager/getTask', $scope.list, function(data) {
                //$scope.tasks = tasks;

                //console.log(data);
                $scope.tasks = data;

                //$scope.taskss = data;

                //return $scope.tasks;

            });
        };

        $scope.deleteTask = function(id) {
            console.log(id);
            request.send('/taskmanager/getTask', $scope.list, function(id) {
                //$scope.tasks = tasks;

                //console.log(data);
                //$scope.tasks = data;

                //$scope.taskss = data;

                //return $scope.tasks;

            });
        };


        /////////////////////////////////////////

        $scope.initTask = function() {
            //request.send('/add_task', {'post':$scope.name_task_block}, function(data) {
            console.log($scope.list);
            request.send('/taskmanager/addTask', $scope.list, function(data) {
                $scope.tasks = data;
                $scope.taskss = data;

                console.log($scope.tasks);
                console.log($scope.taskss);

                return $scope.tasks;
                //$scope.tasks = data;
                //console.log($data);
                //$scope.list = data;
            //request.send('/task/addTask', $scope.list, function(data) {
                //console.log($scope.list);
                //$scope.team_users = data;
                //$scope.pagesList = data;
                //$scope.name_task_block = $scope.name_task_block;
            });
        };

        ///name_task_block








        ///////////////////////////////////////////////////////////////

        $scope.print = function() {
            request.send('/pdf/downloadPdf', {'post': $scope.finances}, function(data) {
            //request.send('downloadPDF', {'post': $scope.finances}, function(data) {

            });
            /*
            request.send('/downloadPDF', {'post': $scope.finances}, function(data) {

            });
            */
        };


        ////////////////////////////////////////////////////////////////////////////////
	};

    /*
    .controller('Task_managerCtrl', ['$scope', function($scope) {
      $scope.list = [];
      $scope.name_task_block = 'hello';
      $scope.submit = function() {
        if ($scope.name_task_block) {
          $scope.list.push(this.name_task_block);
          $scope.name_task_block = '';
        }
      };
    }]);
    */


})();