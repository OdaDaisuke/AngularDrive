<?php
define('IP', $_SERVER['ADDR']);

define('SITE_URL', IP . '/angularDrive/');

define('ROOT_DIR', '/angularDrive/');

define('UPLOAD_DIR', '../storage/');

define('DB_DATABASE','AngularDrive');
define('DB_USERNAME','daisukeoda');
define('DB_PASSWORD','daisukeoda');
define('PDO_DSN','mysql:host=localhost;dbname=' . DB_DATABASE);
