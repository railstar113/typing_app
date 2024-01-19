<?php

declare(strict_types=1);

namespace TypingApp;

class Token
{
  // 送信formチェック用のトークン生成・検証
  public static function create()
  {
    if (empty($_SESSION['token'])) {
      $_SESSION['token'] = bin2hex(random_bytes(32));
    }
  }

  public static function validate()
  {
    if (
      empty($_SESSION['token']) ||
      $_SESSION['token'] !== filter_input(INPUT_POST, 'token')
    ) {
      exit('無効なリクエストです');
    }
  }
}
