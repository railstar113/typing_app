<?php
declare(strict_types=1);

require_once(__DIR__ . '/../library/common.php');

session_start();
if (!isset($_SESSION['id']) || !isset($_SESSION['name'])) {
  header('Location: login.php');
  exit;
}

$_SESSION = array();
session_destroy();

require_once(TEMPLATE_DIR . 'logout.php');
