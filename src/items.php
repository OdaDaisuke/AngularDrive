<?php
require_once 'config.php';
require_once 'functions.php';
require_once 'DB.php';

function getItems($type, $filename) {
  DB::init();
  $result = array();

  switch(strtolower($type)) {

    //ファイルを消す
    case 'delete' :
      $filename = $filename;
      $filePath = '../storage/' . $filename;

      if(is_file($filePath)) {
        $q = 'DELETE FROM item WHERE filename = :filename';
        $stmt = DB::prepare($q);
        $rs = $stmt->execute(array(
          'filename' => $filename
        ));
        unlink($filePath);
        return $rs;
      }

      return false;
      break;

    // ファイル一覧取得
    case 'list' :
      $q = 'SELECT * FROM item LIMIT 20';

      foreach (DB::query($q) as $file)
        array_push($result, $file);

      return $result;
      break;

    // ファイルサイズ取得
    case 'size' :
      $q = 'SELECT SUM(size) FROM item';
      foreach (DB::query($q) as $data)
        array_push($result, $data);

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
