<?php

declare(strict_types=1);

namespace TypingApp;

class Utils
{
  // 特殊文字をHTMLエンティティに変換
  public static function h($str)
  {
    return htmlspecialchars($str, ENT_QUOTES, 'utf-8');
  }
}
