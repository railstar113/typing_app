<?php

declare(strict_types=1);

$title = TITLE_LOGIN;
require_once(TEMPLATE_DIR . 'header.php');

use TypingApp\Utils;
?>

<main>
  <h1>Welcome!</h1>

  <div class="container text_center">
    <p>お好きな単語やフレーズを登録してタイピング練習できるツールです<br />（※ローマ字入力のみ）</p>
    <figure class="login_img_wrap flex h_center gap">
      <img src="img/img_play.jpg" alt="<?= $title; ?>" />
      <img src="img/img_register.jpg" alt="<?= $title; ?>" />
    </figure>
    <form action="login.php" method="post" class="login_form">
      <dl>
        <dt><label for="mail">メールアドレス</label></dt>
        <dd>
          <input type="mail" name="mail" id="mail" required />
        </dd>
        <dt><label for="pass">パスワード</label></dt>
        <dd>
          <input type="password" name="pass" id="pass" minlength="8" required />
        </dd>
      </dl>
      <?php if (isset($msg)) : ?>
        <p class="text_red"><?= Utils::h($msg); ?></p>
      <?php endif; ?>
      <p class="more">
        <button class="button">ログイン</button>
        <input type="hidden" name="token" value="<?= Utils::h($_SESSION['token']); ?>" />
      </p>
      <p><a href="signup.php">ユーザー登録はこちら</a></p>
    </form>
  </div>

</main>

<?php
require_once(TEMPLATE_DIR . 'footer.php');
