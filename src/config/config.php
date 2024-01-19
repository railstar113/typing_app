<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$dbHost = $_ENV['MYSQL_HOST'];
$dbName = $_ENV['MYSQL_DATABASE'];
$dbUser = $_ENV['MYSQL_USER'];
$dbPassword = $_ENV['MYSQL_PASSWORD'];

define('DSN', 'mysql:host=' . $dbHost . ';dbname=' . $dbName . ';charset=utf8mb4');
define('DB_USER', $dbUser);
define('DB_PASS', $dbPassword);
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/');
define('PLAY_URL', SITE_URL . 'play.php');
define('REGISTER_URL', SITE_URL . 'register.php');

// 各ページタイトル
define('TITLE_LOGIN', 'ログイン');
define('TITLE_LOGOUT', 'ログアウト');
define('TITLE_PLAY', '練習しよう');
define('TITLE_REGISTER', 'フレーズ登録');
define('TITLE_SIGNUP_SUCCESS', 'ユーザー登録完了');
define('TITLE_SIGNUP', 'ユーザー登録');