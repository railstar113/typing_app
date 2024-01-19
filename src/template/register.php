<?php

declare(strict_types=1);

$title = TITLE_REGISTER;
require_once(TEMPLATE_DIR . 'header.php');

use TypingApp\Utils;
?>

<main data-token="<?= Utils::h($_SESSION['token']); ?>">
  <h1>Add new phrases!</h1>

  <section>
    <div class="container">
      <h2>登録</h2>

      <form class="register_form">
        <p>
          <input type="text" name="phrase_ja" class="phrase_ja" placeholder="例）さるも木から落ちる" maxlength="57">
        </p>
        <p>
          <input type="text" name="phrase_abc" class="phrase_abc" placeholder="例）sarumokikaraotiru（半角アルファベット）" maxlength="114">
        </p>

        <p class="more text_center">
          <button class="button">登録</button>
        </p>
      </form>
    </div>
  </section>

  <section>
    <div class="container">
      <h2>リスト</h2>

      <ul class="lists">
        <?php foreach ($phrases as $phrase) : ?>
          <li data-id="<?= Utils::h((string) $phrase->id); ?>" class="list">
            <input type="checkbox" class="list_check" <?= $phrase->is_deleted === 1 ? 'checked' : ''; ?>><span class="list_text"><?= Utils::h($phrase->phrase_ja); ?></span>
            <span class="delete">×</span>
          </li>
        <?php endforeach; ?>
      </ul>

      <p class="more flex h_end gap">
        <button type="button" class="button purge">一括削除</button>
        <a href="play.php" class="button">練習する</a>
        <button type="button" class="button logout">ログアウト</button>
      </p>
    </div>
  </section>

</main>

<?php
require_once(TEMPLATE_DIR . 'footer.php');
