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
<<<<<<< HEAD
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


=======
        $scope.card = {};

>>>>>>> a918d0ddcbec8745445fe0e1b1f71e7e12214650

        //$scope.cards.ids = []

<<<<<<< HEAD

=======
        
        $scope.class = "closed";
        $scope.cards = [];
>>>>>>> a918d0ddcbec8745445fe0e1b1f71e7e12214650

        $scope.mass = [];



        $scope.getTask = function() {

<<<<<<< HEAD
            request.send('/taskManager/getTask', $scope.list, function(data) {
                //$scope.tasks = tasks;
=======
            request.send('/TaskManager/getTask', $scope.list, function(data) {
>>>>>>> a918d0ddcbec8745445fe0e1b1f71e7e12214650

                $scope.tasks = data;

                for (var k in data)
                {
                    $scope.cards[k] = data[k].cards;
                }


                //$scope.cards = data[0].cards;
                //console.log($scope.cards);
                //console.log($scope.tasks);


            });
        };

        $scope.deleteTask = function(id) {
            $scope.id = id;
            console.log($scope.id);
            request.send('/TaskManager/deleteTask', {'id': $scope.id}, function(data) {
                $scope.tasks = data;

                for (var k in data)
                {
                    $scope.cards[k] = data[k].cards;
                }



            });
        };


        /////////////////////////////////////////

        $scope.initTask = function() {
            //request.send('/add_task', {'post':$scope.name_task_block}, function(data) {
            console.log($scope.list);
            request.send('/TaskManager/addTask', $scope.list, function(data) {
                $scope.tasks = data;

                for (var k in data)
                {
                    $scope.cards[k] = data[k].cards;
                }

            });
        };

        $scope.createCard = function(id) {
            //request.send('/add_task', {'post':$scope.name_task_block}, function(data) {
            //console.log(id);
            $scope.card.task_id = id;
            request.send('/TaskManager/createCard',$scope.card, function(data) {
                //$scope.card = data;

<<<<<<< HEAD







        ///////////////////////////////////////////////////////////////

        $scope.print = function() {
            request.send('/pdf/downloadPdf', {'post': $scope.finances}, function(data) {
            //request.send('downloadPDF', {'post': $scope.finances}, function(data) {

            });
            /*
            request.send('/downloadPDF', {'post': $scope.finances}, function(data) {

            });
            */
=======
                $scope.tasks = data;

                for (var k in data)
                {
                    $scope.cards[k] = data[k].cards;
                }

            });


>>>>>>> a918d0ddcbec8745445fe0e1b1f71e7e12214650
        };
      




        ////////////////////////////////////////////////////////////////////////////////
	};



})();