<?php

declare(strict_types=1);

namespace TypingApp;

class Tables
{
  public static function create($pdo)
  {
    self::createPhrases($pdo);
    self::createUsers($pdo);
  }

  private static function createPhrases($pdo)
  {
    $sql = <<<SQL
    CREATE TABLE IF NOT EXISTS phrases (
      id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
      phrase_ja VARCHAR(255) NOT NULL,
      phrase_abc VARCHAR(255) NOT NULL,
      is_deleted BOOLEAN DEFAULT FALSE,
      user_id INT NOT NULL,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) DEFAULT CHARACTER SET=utf8mb4;
    SQL;
    $pdo->exec($sql);
  }

  private static function createUsers($pdo)
  {
    $sql = <<<SQL
    CREATE TABLE IF NOT EXISTS users (
      id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(255) NOT NULL,
      mail VARCHAR(255) NOT NULL,
      pass VARCHAR(255) NOT NULL,
      created_at DATETIME,
      updated_at DATETIME
    ) DEFAULT CHARACTER SET=utf8mb4;
    SQL;
    $pdo->exec($sql);
  }
}
