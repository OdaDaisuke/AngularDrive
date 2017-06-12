var app = angular.module('App', []);

var url = {
	items : './src/items.php',
	upload : './src/upload.php'
};

// ajaxリクエスト送るときの設定
app.config(function ($httpProvider) {
	$httpProvider.defaults.transformRequest = function(data){
		if (data === undefined) {
			return data;
		}
		return $.param(data);
	}

	$httpProvider.defaults.headers = function() {
		return {
			'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8'
		};
	}

});

app.controller('MainCtrl', ['$scope', '$http', function($scope, $http) {
	$scope.file = '';
	$scope.selected = [];

	//ストレージからファイル一覧を取ってくる
	(function() {
		$http({
			method : 'POST',
			url : url.items,
			data : {
				dataType : 'list'
			}
		})
		.then(function(res) {
			$scope.items = res;
		},function(res) {
			console.log(res);
		});
	})();

	$scope.fileSubmit = function() {
		var fd = new FormData();
		fd.append('file', $scope.file);

		// post
		$http.post(url.upload, fd, {
			transformRequest : null,
			headers : { 'Content-type' : undefined}
		})
		.success(function(res) {
			$scope.response = res;
			console.log(res);
			if(typeof res.file.error != undefined && res.file.error == 0) {
				$scope.items.data.push([res.file.name]);
			}
		});
	}

	$scope.showItem = function($index) {
		var target = $scope.items.data[$index];

		// zipファイルじゃなかったら普通新規タブで表示
		if(target.indexOf('.zip') == -1) {
			window.open('http://localhost/angularDrive/storage/' + target);

		}
	}

	// クリックでアイテムを選択状態にする
	$scope.selectItem = function($index) {
		if($scope.selected[$index]) {
			$scope.selected[$index] = false;
		} else {
			for(var i = 0;i < $scope.selected.length; i++) {
				$scope.selected[i] = false;
			}
			$scope.selected[$index] = true;
		}
	}

	$scope.deleteItem = function($index) {
		if(confirm($scope.items.data[$index] + 'を削除しますか？')) {
			var target = $scope.items.data[$index];
			$http({
				method : 'POST',
				url : url.items,
				data : {
					dataType : 'delete',
					filename : target
				}
			})
			.then(function(res) {
				if(res.data.indexOf('OK') != -1) {
					$scope.items.data.splice($index, 1);
				}
			},function(res) {
				console.error(res);
			});
		}

	}

}]);

app.directive('fileModel', function($parse) {
	return {
		restrict : 'A',
		link : function(scope, element, attrs) {
			var model = $parse(attrs.fileModel);
			element.bind('change', function() {
				scope.$apply(function() {
					model.assign(scope, element[0].files[0])
				})
			});
		}
	};
});
