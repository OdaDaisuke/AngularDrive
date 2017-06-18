<?php
require_once 'config.php';
require_once 'functions.php';

class DB {
  public static $pdo;

  static function init() {
    try {
      self::$pdo = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
      self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return self::$pdo;
    } catch(PDOException $e) {
      die('DB ERROR');
    }
  }

  static function exec($sql) {
    $q = h($sql);
    return self::$pdo->exec($q);
  }

  static function query($sql) {
    $q = h($sql);
    return self::$pdo->query($q);
  }


  static function close() {
    self::$pdo = null;
  }
}
