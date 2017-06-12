<?php
require_once 'config.php';
require_once 'functions.php';

function getItems($type, $filename) {
  switch(strtolower($type)) {

    //ファイルを消す
    case 'delete' :
      $filename = $filename;
      $filePath = '../storage/' . $filename;

      if(is_file($filePath)) {
        unlink($filePath);
        return array('OK');
      }

      return array('storage/' . $filename);
      break;

    case 'list' :
      // ファイル一覧を取得
      $files = array();
      $handle = opendir('../storage');
      while(($file = readdir($handle)) != false) {
        if($file == '.' || $file == '..') continue;
        array_push($files, $file);
      }
      return $files;

    default :
      return array($type);
  }
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $request = getPost();

  $data = getItems($request['dataType'], $request['filename']);
  exit(json_encode($data));
}
exit(json_encode('error'));
