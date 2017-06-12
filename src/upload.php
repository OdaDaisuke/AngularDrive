<?php
require_once 'config.php';
require_once 'functions.php';

$uploadfile = UPLOAD_DIR . basename($_FILES['file']['name']);

if(move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
  exit(json_encode($_FILES));
} else {
  exit('ERROR!');
}
