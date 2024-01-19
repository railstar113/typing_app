<?php

declare(strict_types=1);

$title = TITLE_PLAY;
require_once(TEMPLATE_DIR . 'header.php');

use TypingApp\Utils;
?>

<main>
  <h1>Let's try typing!</h1>

  <div class="container text_center">
    <p class="text_right font_18">ようこそ&ensp;<?= Utils::h($userName); ?>さん</p>

    <div class="display">
      <div class="display_inner">
        <p id="display_ja"></p>
        <p id="display_abc">
          <span id="typed"></span><span id="untyped"></span>
        </p>
        <div id="display_meter"></div>
      </div>
    </div>

    <div class="keyboard">
      <div class="row row1">
        <div class="key key_1">1</div>
        <div class="key key_2">2</div>
        <div class="key key_3">3</div>
        <div class="key key_4">4</div>
        <div class="key key_5">5</div>
        <div class="key key_6">6</div>
        <div class="key key_7">7</div>
        <div class="key key_8">8</div>
        <div class="key key_9">9</div>
        <div class="key key_0">0</div>
        <div class="key key_minus">-</div>
      </div>
      <div class="row row2">
        <div class="key key_q">Q</div>
        <div class="key key_w">W</div>
        <div class="key key_e">E</div>
        <div class="key key_r">R</div>
        <div class="key key_t">T</div>
        <div class="key key_y">Y</div>
        <div class="key key_u">U</div>
        <div class="key key_i">I</div>
        <div class="key key_o">O</div>
        <div class="key key_p">P</div>
        <div class="key key_at">@</div>
      </div>
      <div class="row row3">
        <div class="key key_a">A</div>
        <div class="key key_s">S</div>
        <div class="key key_d">D</div>
        <div class="key key_f">F</div>
        <div class="key key_g">G</div>
        <div class="key key_h">H</div>
        <div class="key key_j">J</div>
        <div class="key key_k">K</div>
        <div class="key key_l">L</div>
        <div class="key key_semicolon">;</div>
        <div class="key key_colon">:</div>
      </div>
      <div class="row row4">
        <div class="key key_shift">Shift</div>
        <div class="key key_z">Z</div>
        <div class="key key_x">X</div>
        <div class="key key_c">C</div>
        <div class="key key_v">V</div>
        <div class="key key_b">B</div>
        <div class="key key_n">N</div>
        <div class="key key_m">M</div>
        <div class="key key_comma">,</div>
        <div class="key key_period">.</div>
        <div class="key key_slash">/</div>
      </div>
      <div class="row row5">
        <div class="key key_space"></div>
      </div>
    </div>

    <p class="more flex h_end gap">
      <button type="button" class="button retry">もう一度</button>
      <a href="register.php" class="button">フレーズ登録</a>
    </p>
  </div>
  
</main>

<script>
  let phrases = <?= $phrases; ?>;
</script>

<?php
require_once(TEMPLATE_DIR . 'footer.php');
