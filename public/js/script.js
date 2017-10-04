;

(function () {
    'use strict';

    angular.module('app.page')
        .controller('acceptCtrl', ['$scope', '$window', '$location', '$http', '$timeout', '$routeParams', 'logger',  acceptCtrl]);
	
	function acceptCtrl($scope, $window, $location, $http, $timeout, $routeParams, logger)
	{	
		$scope.user = {};
		$scope.init = function()
		{
			$http.post('/api/users/accept', { hash : $routeParams.param}).success(function(data, status){
				$scope.user = data.result.user;
			});
		}
		
		$scope.init();
		
		$scope.accept = function()
		{
			$http.post('/api/users/accept_save', { user : $scope.user}).success(function(data, status){
				if(logger.check(data))
				{
					$timeout(function(){
								$window.location.href = "/";
					}, 2000);
				}
			});
		}
	}
})()

;

;





;

(function () {
    'use strict';

    angular.module('app')
        .controller('WorkersShowCtrl', ['$scope', '$filter', '$http', '$modal', 'logger', WorkersShowCtrl]);

    function WorkersShowCtrl($scope, $filter, $http, $modal, logger) {
        
		$scope.stores = [];
		$scope.numPerPageOpt = [3, 5, 10, 20];
		$scope.numPerPage = $scope.numPerPageOpt[2];
		$scope.currentPage = 1;
		$scope.currentPageStores = [];

        $scope.searchKeywords = "";
        $scope.filteredStores = [];
        $scope.row = "";

		$scope.workers_get = function() {
			$http.post("/api/workers/show_all",  {} ).success(function(data){
				$scope.stores = data.result;
				$scope.init(); 
			});
		}
		
		$scope.workers_get();		

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

        $scope.init = function() {
            $scope.search();
			return $scope.select($scope.currentPage);
        };
		
		$scope.remove_workers = function(finances_id) {
			$http.post("/api/workers/workers_remove",  {"workers_id" : finances_id} ).success(function(data){ 
				logger.check(data);
				$scope.workers_get(); 
			});
		};
	}
})(); 

;

(function () {
    'use strict';

    angular.module('app')
        .controller('WorkersOpenCtrl', ['$scope', '$http', '$modal', 'logger', WorkersOpenCtrl]);

    function WorkersOpenCtrl($scope, $http, $modal, logger) {
		$scope.worker = {};
		$scope.coverletters = {};
		$scope.coverletter_text = "";
		$scope.coverletter_active_id = null;
		$scope.template = { 
			url : 'info'
		};
		
		$scope.get_worker = function() {
			$http.post("/api/workers/get_worker", {"workers_id" : $scope.segment(2) }).success(function(data) {
				$scope.worker = data.result;
			});	
		}
		
		$scope.get_coverletter = function() {
			$http.post("/api/workers/get_coverletters", {"workers_id" : $scope.segment(2) }).success(function(data) {
				$scope.coverletters = data.result;
				$scope.coverletter_text = data.result[0].coverletter_text;
			});	
		}
		
		$scope.change_coverletters = function(text, id){
			$scope.coverletter_active_id = id;
			$scope.coverletter_text = text;
		}
		
		$scope.segment = function(index) {
			var segmetns = window.location.href.split('/');
			for(var i in [0, 1, 2])
			{
				segmetns.shift();
			}
			return segmetns[index];
		}
		
		$scope.remove_coverletters = function(id_coverletters) {
			$http.post("/api/workers/remove_coverletters", {'id_coverletters': id_coverletters}).success(function(data){ 
				if (logger.check(data))
				{
					$scope.get_coverletter();
				}
			});
		};
		
		$scope.edit_coverletters = function(id_coverletters) {
			var modalInstance;
            modalInstance = $modal.open({
                templateUrl: "ModalCoverletter.html",
                controller: 'ModalCoverletterCtrl',
                resolve: {
					coverletter_id : function (){ 
						return id_coverletters; 
					},
					coverletters : function() {
						return $scope.coverletters;
					}
				}
            });
			
            modalInstance.result.then((function() {
				$scope.get_coverletter();
			}), function() {
					
            });
		}
		
		$scope.get_worker();	
		$scope.get_coverletter();
		
		
		$scope.add_coverletter = function(){
			var modalInstance;
            modalInstance = $modal.open({
                templateUrl: "ModalCoverletter.html",
                controller: 'ModalCoverletterCtrl',
				resolve: {
					coverletter_id : function (){ 
						return 0; 
					},
					coverletters : function() {
						return $scope.coverletters;
					}
				}
            });
			
            modalInstance.result.then((function() {
				$scope.get_coverletter();
			}), function() {
					
            });
		}
	}
})()

;

(function () {
    'use strict';

    angular.module('app')
        .controller('ModalCoverletterCtrl', ['$scope', '$modalInstance', '$http', 'coverletter_id', 'coverletters',  'logger', ModalCoverletterCtrl]);
	
	function ModalCoverletterCtrl($scope, $modalInstance, $http, coverletter_id, coverletters, logger) {
		$scope.coverletter = {};
		
		
		$scope.add = function() {
			$http.post("/api/workers/save_coverletters", $scope.coverletter).success(function(data){ 
				if (logger.check(data))
				{
					$modalInstance.close();				
				}
			});
		};
		
		if (coverletter_id)
		{
			for(var i in coverletters)
			{
				if (coverletters[i].coverletters_id * 1 == coverletter_id * 1)
				{
					$scope.coverletter = coverletters[i];
				}
			}
		}
		
		$scope.cancel = function() {
			$modalInstance.dismiss("cancel");
		};
		
		$scope.segment = function(index) {
			var segmetns = window.location.href.split('/');
			for(var i in [0, 1, 2])
			{
				segmetns.shift();
			}
			return segmetns[index];
		};
		
		$scope.coverletter.workers_id = $scope.segment(2);
	}
})()

;