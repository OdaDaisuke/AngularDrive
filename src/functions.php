<?php
// POSTリクエストデータを取得
function getPost() {
  $query = file_get_contents('php://input');
  $datas = explode('&', $query);
  $request = array();

  foreach($datas as $data) {
    $_tmp = explode('=', $data);

    $key = $_tmp[0];
    $val = urldecode($_tmp[1]);

    $request[$key] = $val;
  }

  return $request;
}


// sanitize
function h($s) {
  if(is_array($s)) {
    foreach($s as $val) return h($val);
  } else {
    return htmlspecialchars($s, ENT_QUOTES);
  }
}
