<?php

declare(strict_types=1);

$title = TITLE_LOGOUT;
require_once(TEMPLATE_DIR . 'header.php');
?>

<main>

  <div class="container text_center">
    <p>ログアウトしました</p>
    <p class="more"><a href="login.php" class="button">ログインする</a></p>
  </div>

</main>

<?php
require_once(TEMPLATE_DIR . 'footer.php');
