<?php
require_once 'config.php';
require_once 'functions.php';
require_once 'DB.php';

$uploadfile = UPLOAD_DIR . basename($_FILES['file']['name']);

if(move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
  $pdo = DB::init();
  $q = 'INSERT INTO item (filename, size) VALUES(:filename, :filesize)';
  $stmt = $pdo->prepare($q);
  $stmt->execute(array(
    'filename' => $_FILES['file']['name'],
    'filesize' => $_FILES['file']['size']
  ));

  exit(json_encode($_FILES));
} else {
  exit('ERROR!');
}
