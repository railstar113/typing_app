<?php

declare(strict_types=1);

namespace TypingApp;

class Phrases
{
  private $pdo;

  public function __construct($pdo)
  {
    $this->pdo = $pdo;
    Token::create();
  }

  public function processPost()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      Token::validate();
      $action = filter_input(INPUT_GET, 'action');
      
      switch ($action) {
        case 'add':
          $id = $this->add();
          header('Content-Type: application/json');
          echo json_encode(['id' => $id]);
          break;
        case 'toggle':
          $isDeleted = $this->toggle();
          header('Content-Type: application/json');
          echo json_encode(['is_deleted' => $isDeleted]);
          break;
        case 'delete':
          $this->delete();
          break;
        case 'purge':
          $this->purge();
          break;
        case 'signup':
          $this->addSample();
          require_once(TEMPLATE_DIR . 'signup_success.php');
          exit;
        default:
          exit;
      }

      exit;
    }
  }

  // フレーズの追加・切替・削除
  private function add()
  {
    $phrase_ja = trim(filter_input(INPUT_POST, 'phrase_ja'));
    $phrase_abc = trim(filter_input(INPUT_POST, 'phrase_abc'));
    $user_id = $_SESSION['id'];
    if ($phrase_ja === '' || $phrase_abc === '') {
      return;
    }
    $stmt = $this->pdo->prepare("insert into phrases (phrase_ja, phrase_abc, user_id, created_at, updated_at) values (:phrase_ja, :phrase_abc, :user_id, NOW(), NOW())");
    $stmt->bindValue('phrase_ja', $phrase_ja, \PDO::PARAM_STR);
    $stmt->bindValue('phrase_abc', $phrase_abc, \PDO::PARAM_STR);
    $stmt->bindValue('user_id', $user_id, \PDO::PARAM_INT);
    $stmt->execute();
    return (int) $this->pdo->lastInsertId();
  }

  private function toggle()
  {
    $id = filter_input(INPUT_POST, 'id');
    if (empty($id)) {
      return;
    }
    $stmt = $this->pdo->prepare("select * from phrases where id = :id");
    $stmt->bindValue('id', $id, \PDO::PARAM_INT);
    $stmt->execute();
    $phrase = $stmt->fetch();
    if (empty($phrase)) {
      header('HTTP', true, 404); // HTTP status code
      exit;
    }
    $stmt = $this->pdo->prepare("update phrases set is_deleted = not is_deleted where id = :id");
    $stmt->bindValue('id', $id, \PDO::PARAM_INT);
    $stmt->execute();

    return (boolean) !$phrase->is_deleted;
  }

  private function delete()
  {
    $id = filter_input(INPUT_POST, 'id');
    if (empty($id)) {
      return;
    }
    $stmt = $this->pdo->prepare("delete from phrases where id = :id");
    $stmt->bindValue('id', $id, \PDO::PARAM_INT);
    $stmt->execute();
  }

  private function purge()
  {
    $this->pdo->query("delete from phrases where is_deleted = 1");
  }

  // ユーザー登録時のサンプル登録
  private function addSample()
  {
    $stmt = $this->pdo->prepare("insert into phrases (phrase_ja, phrase_abc, user_id, created_at, updated_at) values (:phrase_ja, :phrase_abc, :user_id, NOW(), NOW())");
    $stmt->bindValue('phrase_ja', 'タイピング', \PDO::PARAM_STR);
    $stmt->bindValue('phrase_abc', 'taipinngu', \PDO::PARAM_STR);
    $stmt->bindValue('user_id', $_SESSION['id'], \PDO::PARAM_INT);
    $stmt->execute();
  }

  // リスト表示
  public function getAll()
  {
    $stmt = $this->pdo->prepare("select * from phrases where user_id = :user_id order by id desc");
    $stmt->bindValue('user_id', $_SESSION['id'], \PDO::PARAM_INT);
    $stmt->execute();
    $phrases = $stmt->fetchAll();
    return $phrases;
  }

  // 練習用のリストを取得
  public function getCheckedAsJson()
  {
    $stmt = $this->pdo->prepare("select * from phrases where is_deleted = 0 and user_id = :user_id");
    $stmt->bindValue('user_id', $_SESSION['id'], \PDO::PARAM_INT);
    $stmt->execute();

    $phraseArray = [];
    while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
      $phraseArray[] = array(
        'id' => $row['id'],
        'phrase_ja' => $row['phrase_ja'],
        'phrase_abc' => $row['phrase_abc'],
        'is_deleted' => $row['is_deleted'],
        'user_id' => $row['user_id']
      );
    }
    return json_encode($phraseArray, JSON_UNESCAPED_UNICODE);
  }
}
