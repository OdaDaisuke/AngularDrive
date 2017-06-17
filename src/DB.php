<?php
require_once 'config.php';

class DB {
  static $db;

  static function init() {
    try {
      self::$db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
      self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return self::$db;
    } catch(PDOException $e) {
      die($e->getMessage());
    }
  }

  static function exec($sql) {
    $q = h($sql);
    self::$db->exec($q);
  }

  static function close() {
    self::$db = null;
  }
}
