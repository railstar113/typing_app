<?php

declare(strict_types=1);

namespace TypingApp;

class Users
{
  private $pdo;

  public function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  // ユーザー検索
  public function get($mail)
  {
    $sql = "select * from users where mail = :mail";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue('mail', $mail);
    $stmt->execute();
    $user = $stmt->fetch(\PDO::FETCH_ASSOC);
    return $user;
  }

  // ユーザー登録
  public function add($name, $mail, $pass)
  {
    $sql = "insert into users (name, mail, pass, created_at, updated_at) values (:name, :mail, :pass, NOW(), NOW());";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue('name', $name);
    $stmt->bindValue('mail', $mail);
    $stmt->bindValue('pass', $pass);
    $stmt->execute();
  }
}
