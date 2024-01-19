<?php

declare(strict_types=1);

require_once(__DIR__ . '/../library/common.php');

use TypingApp\Database;
use TypingApp\Tables;
use TypingApp\Token;
use TypingApp\Users;

session_start();
Token::create();

$pdo = Database::getInstance();
Tables::create($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  Token::validate();

  $mail = isset($_POST['mail']) ? trim(filter_input(INPUT_POST, 'mail')) : '';
  $pass = isset($_POST['pass']) ? trim(filter_input(INPUT_POST, 'pass')) : '';

  $users = new Users($pdo);
  $user = $users->get($mail);

  if (isset($user['pass'])) {
    if (password_verify($pass, $user['pass'])) {
      session_regenerate_id(true);
      $_SESSION['id'] = $user['id'];
      $_SESSION['name'] = $user['name'];
      header('Location:' . PLAY_URL);
      exit;
    } else {
      $msg = 'メールアドレスもしくはパスワードが間違っています';
    }
  } else {
    $msg = 'メールアドレスもしくはパスワードが間違っています';
  }
}

require_once(TEMPLATE_DIR . 'login.php');
