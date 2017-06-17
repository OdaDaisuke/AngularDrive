var app = angular.module('App', ['ui.bootstrap']);

var url = {
	items : './src/items.php',
	upload : './src/upload.php'
};

var path = {
	storage : 'storage/'
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

app.controller('MainCtrl', ['$scope', '$modal', '$http', function($scope, $modal, $http) {
	$scope.file = '';
	$scope.selected = [];

	//現在選択中のファイルの情報が入る
	$scope.currentFile = {
		filename : '',
		modified : 0,
		created : 0,
		ext : '',
		size : 0
	};

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
			console.error(res);
		});
	})();

	//ファイルアップロード
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

			if(typeof res.file.error != undefined && res.file.error == 0) {
				$scope.items.data.push([res.file.name]);
			}

		})
		.error(function(res) {
			console.error(res);
		});
	}


	//選択中のアイテムのファイルタイプを判定。あとで外部関数にする
	var files_ext = {
		image : ['.jpg', '.png', '.jpeg', '.gif', '.svg', '.bmp'],
		video : ['.mov', '.mp4', '.avi', '.mpeg'],
		sound : ['.mp3', '.wav', '.m4a', '.wma'],
		adobe : ['.ai', '.art', '.psd', '.ae', '.xd'],
		win_office : ['.xls'],
		general : ['.txt', '.json', '.yml'],
		program : ['.php', '.rb', '.py', '.js', '.html', '.css', '.scss', '.htm']
	};
	function is_filetype(filename, filetype) {
		if(files_ext[filetype] == undefined) {
			console.error('file type undefined : ' + filetype);
			return false;
		}
		for (var i = 0; i < files_ext[filetype].length; i++) {
			if(filename.indexOf(files_ext[filetype][i]) != -1)
				return true;
		}
		return false;
	}

	//アイテムをモーダル表示
	$scope.showItem = function($index) {

		var filename = $scope.currentFile.filename;

		if(is_filetype(filename, 'image') || is_filetype(filename, 'video')) {
			$modal.open({
				templateUrl : 'modalContentForm',
				controller : 'ModalInstance',
				scope: $scope
			});

			file_showable = false;

		} else {
			alert('Cant preview the file:' + $scope.currentFile.filename);
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
		var filename = $scope.items.data[$index]
		var currentFileInfo = {
			filename : filename,
			src : path.storage + $scope.items.data[$index],
			size : 0,
			is_image : (is_filetype(filename, 'image')),
			is_vide : (is_filetype(filename, 'video')),
			is_adobe : (is_filetype(filename, 'adobe')),
			is_unknown : (!(is_filetype(filename, 'image') ||
				is_filetype(filename, 'video') ||
				is_filetype(filename, 'adobe')))
		};

		$scope.currentFile = currentFileInfo;
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

app.controller('ModalInstance', ['$scope', '$modalInstance', function($scope, $modalInstance) {
	$scope.closeModal = function() {
		$modalInstance.close();
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
