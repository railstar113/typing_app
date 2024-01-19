'use strict';

{
  function validateTyping(phrases) {
    // 最大プレイ回数
    const maxPlayCount = 3;

    // リストに登録がない場合
    const $displayJa = document.getElementById('display_ja');
    const $meter = document.getElementById('display_meter');
    if (!phrases.length) {
      $displayJa.textContent = 'フレーズがありません';
      $meter.remove();
      return;
    }

    // リストに登録がある場合
    const rdmPhrase = () => {
      return phrases[Math.floor(Math.random() * phrases.length)];
    };
    let typed, untyped;
    const $typed = document.getElementById('typed');
    const $untyped = document.getElementById('untyped');
    const $textSet = () => {
      let phrase = rdmPhrase();
      $displayJa.textContent = phrase['phrase_ja'];
      typed = '';
      untyped = phrase['phrase_abc'];
      $typed.textContent = typed;
      $untyped.textContent = untyped;
    }
    $textSet();

    // メーターをMAXにセット
    let meter = maxPlayCount;
    $meter.setAttribute('class', 'len_' + meter);

    // キーボードイベント
    const keyboard = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '-', 'q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p', '@', 'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', ';', ':', 'z', 'x', 'c', 'v', 'b', 'n', 'm', ',', '.', '/', ' '];
    const symbolKeys = {
      ';': 'semicolon',
      '-': 'minus',
      '@': 'at',
      ':': 'colon',
      ',': 'comma',
      '.': 'period',
      '/': 'slash',
      ' ': 'space',
    };
    const renameEventKey = (ekey) => {
      if (!keyboard.includes(ekey)) {
        return 'exception';
      }
      return symbolKeys[ekey] || ekey;
    };

    // keydown
    let correct = 0;
    let wrong = 0;
    let playCount = 0;
    const validateKeyDown = (e) => {
      const downKey = e.key.toLowerCase();
      const renamedDownKey = renameEventKey(downKey);
      if (renamedDownKey === 'exception') {
        wrong++;
        return;
      } else if (renamedDownKey === 'space') {
        e.preventDefault();
      }
      const $downKey = document.querySelector('.key_' + renamedDownKey);

      // 先頭の文字とタイプしたキーが一致しないとき
      if (downKey !== untyped.substring(0, 1).toLowerCase()) {
        $downKey.classList.add('key_wrong');
        wrong++;
        return;
      } else {
        // 先頭の文字とタイプしたキーが一致したとき
        $downKey.classList.add('key_correct');
        correct++;
        typed += untyped.substring(0, 1);
        untyped = untyped.substring(1);
        $typed.textContent = typed;
        $untyped.textContent = untyped;
        // 最後の文字まで終わったら新しいフレーズをセット
        if (untyped === '') {
          $textSet();
          playCount++;
          meter--;
          $meter.setAttribute('class', 'len_' + meter);
        }
        // 最大プレイ回数まで終わった場合
        if (playCount === maxPlayCount) {
          $displayJa.textContent = `正確率は${(Math.round(correct / (correct + wrong) * 100)).toFixed(1)}%です！`;
          $typed.textContent = '';
          $untyped.textContent = '';
          $retryBtn.style.display = 'inline-block';
          document.removeEventListener('keydown', validateKeyDown);
        }
      }
    };
    document.addEventListener('keydown', validateKeyDown);

    // keyupイベント
    let correctUp = 0;
    const validateKeyUp = (e) => {
      const upKey = e.key.toLowerCase();
      const renamedUpKey = renameEventKey(upKey);
      if (renamedUpKey === 'exception') {
        return;
      } else if (renamedUpKey === 'space') {
        e.preventDefault();
      }
      const $upKey = document.querySelector('.key_' + renamedUpKey);
      if ($upKey.classList.contains('key_correct')) {
        correctUp++;
      }
      // keydown時に付与したCSSクラスをリセット
      $upKey.classList.remove('key_wrong');
      $upKey.classList.remove('key_correct');
      if (playCount === maxPlayCount && correctUp === correct) {
        document.removeEventListener('keyup', validateKeyUp);
      }
    };
    document.addEventListener('keyup', validateKeyUp);

    // リトライ
    const retry = () => {
      correct = 0;
      wrong = 0;
      playCount = 0;
      correctUp = 0;
      $textSet();
      meter = maxPlayCount;
      $meter.setAttribute('class', 'len_' + meter);
      $retryBtn.style.display = 'none';
      document.addEventListener('keydown', validateKeyDown);
      document.addEventListener('keyup', validateKeyUp);
    };
    // リトライボタン
    const $retryBtn = document.querySelector('.retry');
    $retryBtn.addEventListener('click', retry);
    // リトライキー
    const retryKey = 'r';
    document.addEventListener('keydown', (e) => {
      if (playCount === maxPlayCount && e.key.toLowerCase() === retryKey) {
        retry();
      }
    });
  }

  if (typeof phrases !== 'undefined') {
    validateTyping(phrases);
  }
}

{
  const token = document.querySelector('main').dataset.token;

  const $phraseJa = document.querySelector('.phrase_ja');
  const $phraseAbc = document.querySelector('.phrase_abc');
  const $lists = document.querySelector('.lists');
  if ($phraseJa) {
    $phraseJa.focus();
  }

  if ($lists) {
    $lists.addEventListener('click', e => {
      // チェックボックスの切り替え
      if (e.target.type === 'checkbox') {
        fetch('?action=toggle', {
          method: 'POST',
          body: new URLSearchParams({
            id: e.target.parentNode.dataset.id,
            token: token,
          }),
        })
          .then(response => {
            if (!response.ok) {
              throw new Error('このフレーズは既に削除されています。');
            }
            return response.json();
          })
          .then(json => {
            if (json.is_deleted !== e.target.checked) {
              alert('このフレーズはすでに更新されています。');
              e.target.checked = json.is_deleted;
            }
          })
          .catch(err => {
            alert(err.message);
            location.reload();
          });
      }

      // 1項目削除
      if (e.target.classList.contains('delete')) {
        if (!confirm('この項目を削除しますか？')) {
          return;
        }

        // span.parentNode.submit();
        fetch('?action=delete', {
          method: 'POST',
          body: new URLSearchParams({
            id: e.target.parentNode.dataset.id,
            token: token,
          }),
        });

        e.target.parentNode.remove();
      }
    });
  }

  // フレーズ登録
  function addPhrase(id, phraseJaValue) {
    const $li = document.createElement('li');
    $li.dataset.id = id;
    $li.classList.add('list');

    const $checkbox = document.createElement('input');
    $checkbox.type = 'checkbox';
    $checkbox.classList.add('list_check');

    const $text = document.createElement('span');
    $text.classList.add('list_text');
    $text.textContent = phraseJaValue;

    const $deleteMark = document.createElement('span');
    $deleteMark.classList.add('delete');
    $deleteMark.textContent = '×';

    $li.appendChild($checkbox);
    $li.appendChild($text);
    $li.appendChild($deleteMark);

    $lists.insertBefore($li, $lists.firstChild);
  }

  const $registerForm = document.querySelector('.register_form');
  if ($registerForm) {
    $registerForm.addEventListener('submit', e => {
      e.preventDefault();  // ページ遷移(フォーム送信)防止
      if ($phraseJa.value === '' || $phraseAbc.value === '') {
        return;
      }
      const phraseJaValue = $phraseJa.value;
      const phraseAbcValue = $phraseAbc.value;

      fetch('?action=add', {
        method: 'POST',
        body: new URLSearchParams({
          phrase_ja: phraseJaValue,
          phrase_abc: phraseAbcValue,
          token: token,
        }),
      })
      .then(response => response.json())
      .then(json => {
        addPhrase(json.id, phraseJaValue);
      });

      $phraseJa.value = '';
      $phraseAbc.value = '';
      if ($phraseJa) {
        $phraseJa.focus();
      }
    });
  }

  // チェック項目を一括削除
  const $purge = document.querySelector('.purge');
  if ($purge) {
    $purge.addEventListener('click', () => {
      if (!confirm('チェック項目を削除しますか？')) {
        return;
      }

      fetch('?action=purge', {
        method: 'POST',
        body: new URLSearchParams({
          token: token,
        }),
      });

      const $lis = document.querySelectorAll('li');
      $lis.forEach(li => {
        if (li.children[0].checked) {
          li.remove();
        }
      });
    });
  }
}

{
  // ログアウト
  const logoutUrl = window.location.origin + '/logout.php';
  const $logout = document.querySelector('.logout');
  if ($logout) {
    $logout.addEventListener('click', () => {
      if (!confirm('ログアウトしますか？')) {
        return;
      }
      window.location.href = logoutUrl;
    });
  }
}
