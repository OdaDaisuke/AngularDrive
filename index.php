<?php

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="shortcut icon" size="16" href="./assets/favicon/favicon16.png">
  <link rel="shortcut icon" size="32" href="./assets/favicon/favicon32.png">
  <link rel="shortcut icon" size="48" href="./assets/favicon/favicon48.png">
  <link rel="shortcut icon" size="64" href="./assets/favicon/favicon64.png">
  <link rel="canonical" href="https://sample.jp/">
  <meta property="og:title" content="Lifmo" >
  <meta property="og:url" content="https://sample.jp/">
  <meta property="og:image" content="https://sample.jp/sample.png">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <meta property="og:site_name" content="SiteName">
  <meta property="fb:admins" content="FB_ADMIN">
  <meta property="og:description" content="サンプル説明文" />
  <meta name="twitter:card" content="summary">
  <meta name="twitter:site" content="@tiwtter_id">
  <meta name="twitter:domain" content="https://twitter.com/your_id">
  <meta name="twitter:title" content="title">
  <meta name="twitter:description" content="サンプル説明文">
  <meta name="twitter:image" content="https://sample.jp/sample.jpg">
  <meta itemprop="image" content="https://sample.jp/sample.jpg">
  <meta name="description" content="サンプル説明文">
  <meta name="keywords" content="キーワード,キーワード2">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.1.0/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.10.0/ui-bootstrap-tpls.min.js"></script>
  <script src="./assets/scripts/app.js"></script>
  <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="./d/styles/style.css">
  <title>AngularDrive</title>
</head>
<body ng-app="App" ng-controller="MainCtrl">
  <div class="row">
    <section id="left" class="panel">
      <div class="inner">
        <div class="green">
          <h4 class="p-a text-white">メニュー</h4>
          <ul class="side-menu">
            <li><i class="ion-ios-time current icon"></i>最近のファイル</li>
            <li><i class="ion-star icon"></i>スター</li>
            <li><i class="ion-trash-a icon"></i>ゴミ箱</li>
          </ul>
        </div>
        <div class="p-a">
          <p class="text--help">45.4MB used.</p>
        </div>
      </div>
    </section>
    <section id="center" class="panel">
      <div class="inner">
        <div class="p-lg bordered--bottom">
          <h4 class="text--help">アップロード</h4>
          <input type="file" file-model="file">
          <button class="btn" ng-click="fileSubmit()">アップロード</button>
        </div>
        <div class="">
          <h2 class="green p-a text-white">Storage</h2>
          <ul class="files-list">
            <li ng-repeat="item in items.data" ng-class="{selected: selected[$index]}" ng-click="selectItem($index)" ng-dblclick="showItem($index)" ng-model="itemLI">
              <div class="flex-6">
                {{item}}
                <i class="ion-trash-a" ng-model="deleteBtn" ng-click="deleteItem($index)"></i>
              </div>
              <div class="flex-3">
              </div>
              <div class="flex-3">
              </div>
            </li>
          </ul>
        </div>
      </div>
    </section>
    <section id="right" class="panel">
      <div class="inner p-a">
        <h3>ファイル詳細</h3>
        <p>{{currentFile.filename}}</p>
        <p>Size : {{currentFile.size}}</p>
        <p>Created : {{currentFile.size}}</p>
        <p>Modified : {{currentFile.size}}</p>
        <p>File Type :
          <span ng-show="currentFile.is_image">Image</span>
          <span ng-show="currentFile.is_video">Video</span>
          <span ng-show="currentFile.is_adobe">Adobe</span>
          <span ng-show="currentFile.is_unknown">unknown</span>
        </p>
      </div>
    </section>
  </div>
  <script type="text/ng-template" id="modalContentForm" class="modal-wrap">
    <div id="modalContent" class="inner">
      <div class="modal-header">
        <h3>{{currentFile.filename}}</h3>
      </div>
      <div class="modal-body">
        <img ng-show="currentFile.is_image" ng-src="{{currentFile.src}}">
        <div class="modal-overlay" ng-click="closeModal()"></div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </script>
</body>
</html>
