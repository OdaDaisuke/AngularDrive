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
          <p class="text--help"><span ng-model="fileSizeSum"></span> used.</p>
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
          <table class="files-list">
            <tr class="item flex transparent">
              <th class="flex-6">ファイル名</th>
              <th class="flex-3">作成日</th>
              <th class="flex-3">サイズ</th>
            </tr>
            <tr ng-repeat="item in items" class="item flex" ng-class="{selected: selected[$index]}" ng-click="selectItem($index)" ng-dblclick="showItem($index)" ng-model="itemLI">
              <th class="flex-6">
                <span class="m-r-a">{{item.filename}}</span>
                <i class="ion-trash-a" ng-model="deleteBtn" ng-click="deleteItem($index)"></i>
              </th>
              <td class="flex-3">
                {{item.created}}
              </td>
              <td class="flex-3">
                {{moldFileSize(item.size)}}
              </td>
            </tr>
          </table>
        </div>
      </div>
    </section>
    <section id="right" class="file-detail">
      <div class="inner">
        <div class="p-lg">
          <h4 class="file-name">{{currentFile.filename}}</h4>
        </div>
        <div class="p-r-a p-l-a">
          <img ng-show="currentFile.is_image" ng-src="{{currentFile.src}}">
        </div>
        <div class="p-lg">
          <table class="file-detail-table">
            <tr>
              <th>サイズ<th>
              <td>{{currentFile.size}}</td>
            </tr>
            <tr>
              <th>作成日<th>
              <td>{{currentFile.created}}</td>
            </tr>
            <tr>
              <th>更新日<th>
              <td>{{currentFile.modified}}</td>
            </tr>
            <tr>
              <th>タイプ<th>
              <td>
                <span ng-show="currentFile.is_image">Image</span>
                <span ng-show="currentFile.is_video">Video</span>
                <span ng-show="currentFile.is_adobe">Adobe</span>
                <span ng-show="currentFile.is_unknown">unknown</span>
              </td>
            </tr>
          </table>
        </div>
      </div>
    </section>
  </div>
  <div id="modalContentDivForm" class="modal-wrap" ng-class="{visible : is_modal_open}">
    <div id="modalContent" class="inner">
      <div class="modal-header text-center">
        <h3 class="modal-title text-white">{{currentFile.filename}}</h3>
      </div>
      <div class="modal-body">
        <div class="modal-content">
          <img ng-show="currentFile.is_image" ng-src="{{currentFile.src}}">
        </div>
        <div class="modal-overlay" ng-click="closeModal()"></div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</body>
</html>
