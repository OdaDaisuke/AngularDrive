<?php
require_once 'config.php';
require_once 'functions.php';
require_once 'DB.php';

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
      DB::init();
      $q = 'SELECT * FROM item LIMIT 20';
      $result = array();

      foreach (DB::query($q) as $file) {
        array_push($result, $file);
      }

      return $result;
      break;

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
