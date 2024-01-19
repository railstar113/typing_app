<?php

declare(strict_types=1);

require_once(__DIR__ . '/../library/common.php');

use TypingApp\Database;
use TypingApp\Phrases;
use TypingApp\Token;
use TypingApp\Users;

session_start();
Token::create();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  Token::validate();
  $pdo = Database::getInstance();
  $name = isset($_POST['name']) ? trim(filter_input(INPUT_POST, 'name')) : '';
  $mail = isset($_POST['mail']) ? trim(filter_input(INPUT_POST, 'mail')) : '';
  $unhash_pass = isset($_POST['pass']) ? trim(filter_input(INPUT_POST, 'pass')) : '';
  $pass = password_hash($unhash_pass, PASSWORD_DEFAULT);

  $users = new Users($pdo);
  $user = $users->get($mail);

  if (isset($user['mail'])) {
    if ($user['mail'] === $mail) {
      $msg = '同じメールアドレスが存在します';
    }
  } else if (empty($name) || empty($mail) || empty($pass)) {
    $msg = 'ユーザー名、メールアドレス、パスワードを入力してください';
  } else {
    $users->add($name, $mail, $pass);
    $user = $users->get($mail);
    session_regenerate_id(true);
    $_SESSION['id'] = $user['id'];
    $_SESSION['name'] = $user['name'];

    $phrase = new Phrases($pdo);
    $phrase->processPost();
  }
}

require_once(TEMPLATE_DIR . 'signup.php');
