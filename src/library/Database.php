<?php

declare(strict_types=1);

namespace TypingApp;

class Database
{
  private static $instance;

  // データベース接続
  public static function getInstance()
  {
    try {
      if (!isset(self::$instance)) {
        self::$instance = new \PDO(
          DSN,
          DB_USER,
          DB_PASS,
          [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
            \PDO::ATTR_EMULATE_PREPARES => false,
            \PDO::MYSQL_ATTR_INIT_COMMAND => "SET time_zone='+09:00'",
          ]
        );
      }
      return self::$instance;
    } catch (\PDOException $e) {
      echo 'DB接続エラー:' . $e->getMessage();
      exit;
    }
  }
}
