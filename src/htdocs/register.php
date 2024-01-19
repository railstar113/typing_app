<?php

declare(strict_types=1);

require_once(__DIR__ . '/../library/common.php');

use TypingApp\Database;
use TypingApp\Phrases;

session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['name'])) {
  header('Location: login.php');
  exit;
}

$pdo = Database::getInstance();
$phrase = new Phrases($pdo);
$phrase->processPost();
$phrases = $phrase->getAll();

require_once(TEMPLATE_DIR . 'register.php');
