(function () {
    'use strict';

    angular.module('app')
        .controller('WorkerCtrl', ['$scope', '$http', 'Upload', '$window', '$timeout', 'logger', WorkerCtrl]);
	 
	function WorkerCtrl($scope, $http, Upload, $window, $timeout, logger) {
		$scope.user = {};
		$scope.fd = new FormData();
		$scope.xhr = new XMLHttpRequest;
		$scope.fr  = new FileReader();
		
		$scope.files = {};
		$scope.files.doc = {}
		$scope.files.photo = {};
		$scope.tags = ['PHP', 'PSD to HTML'];
		
		$scope.facebook_check = 0;
		$scope.vk_check = 0;
		
		$scope.loadItems = function(query) {
            $http.post("/api/workers/search_skill", {"query" : query}).compile(function(data){
				return data.result;
			});
		};
		
		$scope.add = function()
		{
			for (var i in $scope.user)
			{
				$scope.fd.append(i, $scope.user[i]);
            }
			
            var tags_array = [];
            for (var i in $scope.tags)
			{
               tags_array.push($scope.tags[i].text);
            }
            
            $scope.fd.append('tags', JSON.stringify(tags_array));
            
			$scope.xhr.open("post", "/api/workers/add_workers");
			$scope.xhr.onload = function()
			{
				if ($scope.xhr.readyState == 4)
				{
					logger.check(JSON.parse($scope.xhr.responseText));
					$timeout(function(){
							$window.location.href = "/";
					}, 2000);
				}
			}
			$scope.xhr.send($scope.fd);
		}
		
		$scope.get_file = function(file, type)
		{	

			if (file)
			{	
				if (type !== 'doc')
				{
					$scope.fr.readAsDataURL(file);
					$scope.fd.append(type, file);
				}
				else 
				{
					for (var i=0; i < file.length; i++)
					$scope.fd.append(type + i, file[i]);
				}
				
					
				
				$scope.fr.onload = function(event) 
				{
					$scope.files[type].progress = Math.ceil(Math.min(100, parseInt(100.0 * event.loaded / event.total)) / 2);
				}
				
				$scope.fr.onloadend = function()
				{
					$scope.files[type].base64 = $scope.fr.result;
					$scope.files[type].progress = 100;
				}
			}
		}
	}
})()
;