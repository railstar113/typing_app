<?php

declare(strict_types=1);

$title = TITLE_SIGNUP;
require_once(TEMPLATE_DIR . 'header.php');

use TypingApp\Utils;
?>

<main>
  <h1>Sign up</h1>

  <div class="container text_center">
    <form action="?action=signup" method="post" class="signup_form">
      <dl>
        <dt><label for="name">ユーザー名</label></dt>
        <dd><input type="text" name="name" id="name"></dd>
        <dt><label for="mail">メールアドレス</label></dt>
        <dd><input type="mail" name="mail" id="mail"></dd>
        <dt><label for="pass">パスワード</label></dt>
        <dd><input type="password" name="pass" id="pass" minlength="8"></dd>
      </dl>
      <?php if (isset($msg)) : ?>
        <p class="text_red"><?= Utils::h($msg); ?></p>
      <?php endif; ?>
      <p class="more">
        <button class="button">新規登録</button>
        <input type="hidden" name="token" value="<?= Utils::h($_SESSION['token']); ?>" />
      </p>
      <p><a href="login.php">ユーザー登録済みの方はこちら</a></p>
    </form>
  </div>

</main>

<?php
require_once(TEMPLATE_DIR . 'footer.php');
