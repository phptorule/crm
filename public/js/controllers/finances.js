(function () {
    'use strict';

    angular.module('app').controller('FinancesCtrl', ['$rootScope', '$scope', '$uibModal', '$filter', 'request', 'langs', FinancesCtrl]);

    function FinancesCtrl($rootScope, $scope, $uibModal, $filter, request, langs) {
    	$scope.list = [];
    	$scope.listFiltered = [];
		$scope.pagesList = [];
    	$scope.numPerPage = 20;
		$scope.currentPage = 1;

		$scope.types_list = ['By Month', 'By Year', 'Custom Period'];
		$scope.months_list = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

		$scope.filter = {};
		$scope.filter.type = '0';
		$scope.filter.month = (new Date()).getMonth().toString();
		$scope.filter.year = (new Date()).getFullYear().toString();
		$scope.filter.payer = '';

		$scope.teams = [];
		$scope.currentTeam = {};
		$scope.init = function() {
			$scope.getTeams();
			$scope.getCurrency();
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

			$scope.reloadData();
		};

    	$scope.get = function() {
    		$scope.filter.teams_id = $scope.currentTeam.teams_id;
			request.send('/finances/get', $scope.filter, function(data) {
				$scope.print(data);
			});
		};

		$scope.summary = {
			'all': 0,
			'plus': 0,
			'minus': 0
		};

		$scope.getSummary = function() {
			$scope.summary.all = 0;
			$scope.summary.plus = 0;
			$scope.summary.minus = 0;
			for (var k in $scope.list)
			{
				if ($scope.list[k].finances_type == '0')
				{
					$scope.summary.all -= $scope.list[k].finances_amount_uah * 1;
					$scope.summary.minus -= $scope.list[k].finances_amount_uah * 1;
				}
				else
				{
					$scope.summary.all += $scope.list[k].finances_amount_uah * 1;
					$scope.summary.plus += $scope.list[k].finances_amount_uah * 1;
				}
			}
		};

		$scope.getYearRange = function() {
			var currentYear = (new Date()).getFullYear();
			var range = [];
			for (var i = 2017; i <= currentYear; i++)
			{
				range.push(i);
			}
			return range;
		};

		$scope.currency = [];
		$scope.getCurrency = function() {
			request.send('/finances/getCurrency', {'teams_id': $scope.currentTeam.teams_id}, function(data) {
				if (data)
				{
					$scope.currency = data;
				}
			});
		};

		$scope.payers = [];
		$scope.getPayers = function() {
			request.send('/finances/getPayers', {'teams_id': $scope.currentTeam.teams_id}, function(data) {
				if (data)
				{
					$scope.payers = data;
				}
			});
		};

		$scope.descs = [];
		$scope.getDescs = function() {
			request.send('/finances/getDescs', {'teams_id': $scope.currentTeam.teams_id}, function(data) {
				if (data)
				{
					$scope.descs = data;
				}
			});
		};

		$scope.balance = 0;
		$scope.getBalance = function() {
			request.send('/finances/getBalance', {'teams_id': $scope.currentTeam.teams_id}, function(data) {
				$scope.balance = data * 1;
			});
		};

		$scope.add = function(finances_id) {
            finances_id = finances_id || false;

			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: 'FinancesAdd.html',
				controller: 'ModalFinancesAddCtrl',
				resolve: {
					items: function () {
				  		return {
				  			'teams_id': $scope.currentTeam.teams_id,
				  			'finance': $scope.by_id(finances_id),
				  			'currency': $scope.currency,
				  			'payers': $scope.payers,
				  			'descs': $scope.descs
				  		};
					}
				}
		    });

		    modalInstance.result.then(function(response) {
				$scope.reloadData();
		    }, function () {
				
		    });
		};

		$scope.remove = function(finances_id) {
            if (confirm(langs.get('Do you really want to remove this record?')))
            {
                request.send('/finances/remove', {'finances_id': finances_id}, function(data) {
                    $scope.reloadData();
                });
            }
        };

        $scope.reloadData = function() {
        	$scope.get();
        	$scope.getPayers();
        	$scope.getDescs();
			$scope.getBalance();
        };

		$scope.print = function(data) {
			$scope.list = data;
			$scope.listFiltered = $scope.list;
			$scope.order('-finances_date');
			$scope.getSummary();
		};

		$scope.by_id = function(finances_id) {
			for (var k in $scope.list)
			{
				if ($scope.list[k].finances_id == finances_id)
				{
					return $scope.list[k];
				}
			}

			return {};
		};

		$scope.changePage = function(page) {
            var end, start;
            start = (page - 1) * $scope.numPerPage;
            end = start + $scope.numPerPage;

            //return $scope.pagesList = $scope.listFiltered.slice(start, end);
            return $scope.pagesList = $scope.listFiltered;
        };

        $scope.order = function(rowName) {
            $scope.row = rowName;
            $scope.listFiltered = $filter('orderBy')($scope.list, rowName);

            $scope.changePage(1);
            return $scope.currentPage = 1;
        };

        $scope.toDate = function(str) {
        	return new Date(str);
        };

        $scope.getCurrencySign = function(currency_id, main) {
        	main = main || false;
        	for (var k in $scope.currency)
        	{
        		if (currency_id && currency_id == $scope.currency[k].currency_id || main && $scope.currency[k].currency_main == '1')
        		{
        			return $scope.currency[k].currency_sign;
        		}
        	}
        	return '';
        };

        $scope.getCurrencyName = function(currency_id, main) {
        	main = main || false;
        	for (var k in $scope.currency)
        	{
        		if (currency_id && currency_id == $scope.currency[k].currency_id || main && $scope.currency[k].currency_main == '1')
        		{
        			return $scope.currency[k].currency_name;
        		}
        	}
        	return '';
        };

        $scope.dateOptions = {
			startingDay: 1,
			showWeeks: false
		};

		$scope.from = {
		    opened: false
		};

		$scope.to = {
		    opened: false
		};

		$scope.calendarOpen = function(type) {
			$scope[type].opened = true;
		};

		$scope.setDate = function() {
			var date = new Date();
			$scope.filter.from = new Date(date.getFullYear(), date.getMonth(), 1, 0, 0, 0);
			$scope.filter.to = date;
		};
		$scope.setDate();
    };
})();

;

(function () {
    'use strict';

    angular.module('app').controller('ModalFinancesAddCtrl', ['$rootScope', '$scope', '$uibModalInstance', 'request', 'validate', 'logger', 'langs', 'items', ModalFinancesAddCtrl]);

    function ModalFinancesAddCtrl($rootScope, $scope, $uibModalInstance, request, validate, logger, langs, items) {
        $scope.teams_id = items.teams_id;
        $scope.currency = angular.copy(items.currency);
        $scope.payers = angular.copy(items.payers);
        $scope.descs = angular.copy(items.descs);
        $scope.finance = angular.copy(items.finance);
        if ( ! $scope.finance.finances_id)
        {
        	$scope.finance.finances_type = 0;
        }
        else
        {
        	$scope.finance.finances_amount *= 1;
        	$scope.finance.finances_amount_uah *= 1;
        	$scope.finance.finances_course *= 1;
        }


		$scope.mainCurrecy = function() {
    		for (var k in $scope.currency)
    		{
    			if ($scope.currency[k].currency_main == '1')
    			{
    				return $scope.currency[k];
    			}
    		}

    		return {};
    	};

    	$scope.currentCurrecy = function() {
    		var currency_id = $scope.finance.currency_id || $scope.mainCurrecy().currency_id;
    		for (var k in $scope.currency)
    		{
    			if ($scope.currency[k].currency_id == currency_id)
    			{
    				$scope.finance.currency_id = currency_id;
    				return $scope.currency[k];
    			}
    		}

    		return {};
    	};

    	$scope.setCurrency = function(currency_id) {
    		$scope.finance.currency_id = currency_id;
    	};

    	$scope.setType = function(type) {
    		$scope.finance.finances_type = type;
    	};

    	$scope.save = function() {
	    	var error = 1;
			error *= validate.check($scope.form.finances_amount, 'Amount');
			error *= validate.check($scope.form.finances_date, 'Date');
			error *= validate.check($scope.form.finances_payer, 'Payer');
			error *= validate.check($scope.form.finances_desc, 'Description');
			if (error)
			{
				$scope.finance.teams_id = $scope.teams_id;
				$scope.finance.finances_date = $scope.dt;
				request.send('/finances/save', $scope.finance, function(data) {
					if (data)
					{
						$uibModalInstance.close(data);
					}
				});
			}
		};

		$scope.cancel = function() {
			$uibModalInstance.dismiss('cancel');
		};

        $scope.dateOptions = {
			startingDay: 1,
			showWeeks: false
		};

		$scope.calendar = {
		    opened: false
		};

		$scope.calendarOpen = function() {
			$scope.calendar.opened = true;
		};

		$scope.setDate = function() {
			$scope.dt = ($scope.finance.finances_date) ? (new Date($scope.finance.finances_date)) : (new Date());
		};
		$scope.setDate();
    };
})();

;