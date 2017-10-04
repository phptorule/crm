(function () {
    'use strict';
angular.module('app')
        .controller('FinancesCtrl', ['$scope', '$filter', '$http', '$modal', 'logger', FinancesCtrl]);

    function FinancesCtrl($scope, $filter, $http, $modal, logger) {
        
		$scope.stores = [];
		$scope.filter = {};
		$scope.format = 'dd-MM-yyyy';
		$scope.numPerPage = 20;
		$scope.currentPage = 1;
		$scope.currentPageStores = [];
		$scope.opened = {"from" : false, "to": false};
        $scope.searchKeywords = "";
        $scope.filteredStores = [];
        $scope.row = "";
		$scope.payers = [];
		$scope.payers_list = [];
		$scope.currency = [];
		
		$scope.finances = {};
		$scope.finances.income = 0;
		$scope.finances.costs = 0;
		$scope.finances.period = 0;
		$scope.finances.balance = 0;
		
		$scope.get_currency = function() {
			$http.post("/api/finances/get_currency/",  {}).success(function(data){ 
				$scope.currency = data.result;
			});
		}
		
		$scope.get_payers = function() {
			$http.post("/api/finances/get_payers/",  {}).success(function(data) {
				$scope.payers_list = data.result;
				$scope.payers = [{"payers_id" : 0, "payers_name" : "All"}].concat($scope.payers_list);
				$scope.filter.payers = $scope.payers[0];
			});
		}
		
		$scope.get_currency(); 
		$scope.get_payers(); 
		
		//$scope.currencys = [];
		//$scope.payers = [];
		
		$scope.finances_get = function() {
			$http.post("/api/finances/finances_get",  {"filter" : $scope.filter} ).success(function(data){ 
				$scope.stores = data.result.list;
				//$scope.payers = data.result.payers;
				//$scope.payers.unshift({"payers_id" : 0, "payers_name" : "All"});
				$scope.finances.balance = data.result.balance;
				//
				$scope.init(); 
				console.log($scope.filter.date_from);
			});
		}
		
		$scope.finances_get();		

        $scope.select = function(page) {
            var end, start;
            start = (page - 1) * $scope.numPerPage;
            end = start + $scope.numPerPage;
            return $scope.currentPageStores = $scope.filteredStores.slice(start, end);
        };

        $scope.onFilterChange = function() {
            $scope.select(1);
            $scope.currentPage = 1;
            return $scope.row = "";
        };

        $scope.onNumPerPageChange = function() {
            $scope.select(1);
            return $scope.currentPage = 1;
        };

        $scope.onOrderChange = function() {
            $scope.select(1);
            return $scope.currentPage = 1;
        };

        $scope.search = function() {
            $scope.filteredStores = $filter('filter')($scope.stores, $scope.searchKeywords);
			$scope.recalculation();
			//$scope.modaldata.filteredStores = $scope.filteredStores;
            return $scope.onFilterChange();
        };

        $scope.order = function(rowName) {
            if ($scope.row === rowName) {
                return;
            }
            $scope.row = rowName;
            $scope.filteredStores = $filter('orderBy')($scope.stores, rowName);
            return $scope.onOrderChange();
        };

		$scope.recalculation = function() {
			
			$scope.finances.costs = 0;
			$scope.finances.income = 0;
			$scope.finances.period = 0;
			
			for(var i in $scope.filteredStores)
			{
				var item = $scope.filteredStores[i];
				if (item.finances_type == 0)
				{
					$scope.finances.costs += item.finances_amount * 1;
				}
				else
				{
					$scope.finances.income += item.finances_amount * 1;
				}
			}
			
			$scope.finances.period = $scope.finances.income - $scope.finances.costs;
		}
		
        $scope.init = function() {
            $scope.search();
			return $scope.select($scope.currentPage);
        };
		
		$scope.today = function() {
            $scope.filter.date_from = new Date();
			$scope.filter.date_to = new Date();
        };

        $scope.today();

        $scope.showWeeks = true;

        $scope.toggleWeeks = function() {
            $scope.showWeeks = ! $scope.showWeeks;
        };

        $scope.disabled = function(date, mode) {
            mode === 'day' && (date.getDay() === 0 || date.getDay() === 6);
        };

        $scope.toggleMin = function() {
            var _ref;
            $scope.minDate = (_ref = $scope.minDate) != null ? _ref : {
                "null": new Date()
            };
        };

        $scope.toggleMin();

        $scope.open = function($event, piker) {
            $event.preventDefault();
            $event.stopPropagation();
            $scope.opened[piker] = true; 
        };

        $scope.dateOptions = {
            'year-format': "'yy'",
            'starting-day': 1
        };
		$scope.remove_finances = function(finances_id) {
			$http.post("/api/finances/finances_remove",  {"finances_id" : finances_id} ).success(function(data){ 
				logger.check(data);
				$scope.finances_get(); 
			});
		};
		
		$scope.add_finances = function(finances_id) {
            var modalInstance;
            modalInstance = $modal.open({
                templateUrl: "ModalFinances.html",
                controller: 'ModalFinancesCtrl',
                resolve: {
                    modaldata : function(){
						return {'payers_list': $scope.payers_list, 'currency': $scope.currency};
						},
					finances_id : function (){ 
						return finances_id; 
						}
				}
            });
			
            modalInstance.result.then((function(selectedItem) {
				$scope.finances_get();
			}), function() {
					
            });
        };		
	}
})(); 

(function () {
    'use strict';

    angular.module('app')
        .controller('ModalFinancesCtrl', ['$scope', '$modalInstance', '$http', 'logger', 'modaldata', 'finances_id', ModalFinancesCtrl]);
	
	function ModalFinancesCtrl($scope, $modalInstance, $http, logger, modaldata, finances_id) {
		
		$scope.finances = {};
		$scope.finances.finances_id = finances_id;
		$scope.finances.finances_amount = null;
		$scope.finances.currency = null;
		$scope.finances.payers = null;
		$scope.finances.finances_type = 1;
		$scope.finances.finances_payer = null;
		$scope.finances.finances_date = null;
		$scope.finances.finances_desc = null;
		$scope.opened = false;
		
		$scope.payers = [{"payers_id" : 0, "payers_name" : "Not in list"}].concat(modaldata.payers_list);
		$scope.currencys = modaldata.currency;
		
		
		$scope.today = function()
		{
			$scope.finances.finances_date = new Date();
		}
		
		if ( ! finances_id)
		{
			$scope.finances.currency = $scope.currencys[0];
			$scope.finances.payers = $scope.payers[0];
			$scope.today();
		}
		else
		{
			for(var i in modaldata.filteredStores)
			{
				if (modaldata.filteredStores[i].finances_id * 1 == finances_id * 1)
				{
					$scope.finances.finances_amount = modaldata.filteredStores[i].finances_original;
					$scope.finances.finances_desc = modaldata.filteredStores[i].finances_desc;
					$scope.finances.finances_payer = modaldata.filteredStores[i].finances_payer;
					$scope.finances.finances_type = modaldata.filteredStores[i].finances_type;
					$scope.finances.finances_date = modaldata.filteredStores[i].finances_date;
					
					for(var j in $scope.currencys)
					{
						if ($scope.currencys[j].currency_id * 1 == modaldata.filteredStores[i].currency_id * 1)
						{
							$scope.finances.currency = $scope.currencys[j];
						}
					}
					
					for(var j in $scope.payers)
					{
						if ($scope.payers[j].payers_id * 1 == modaldata.filteredStores[i].payers_id * 1)
						{
							$scope.finances.payers = $scope.payers[j];
						}
					}
				}
			}
		}

		$scope.open = function($event) {
            $event.preventDefault();
            $event.stopPropagation();
			$scope.opened = true;
        };
		
		$scope.change_payer = function()
		{
			for(var i in $scope.payers)
			{
				if ($scope.finances.payers.payers_id && $scope.payers[i].payers_id == $scope.finances.payers.payers_id)
				{
					$scope.finances.finances_payer = $scope.payers[i].payers_name;
				}
				else if ( ! $scope.finances.payers.payers_id)
				{
					$scope.finances.finances_payer = "";
				}
			}
		}
		
		$scope.save = function() {
			$http.post("/api/finances/finances_save", $scope.finances).success(function(data){ 
				if (logger.check(data))
				{
					$modalInstance.close();				
				}
			});
		};

		$scope.cancel = function() {
			$modalInstance.dismiss("cancel");
		};
	}
})();