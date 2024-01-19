<?php

declare(strict_types=1);

$url = $_SERVER['REQUEST_URI'];
$path = parse_url($url, PHP_URL_PATH);
$slug = pathinfo($path, PATHINFO_FILENAME);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>タイピングツール<?= $title ? ' | ' . $title : ''; ?></title>
  <link rel="icon" href="img/favicon.ico">
  <link rel="apple-touch-icon" sizes="180x180" href="img/apple-touch-icon-180x180.png">
  <link rel="stylesheet" href="https://unpkg.com/modern-css-reset/dist/reset.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body class="page_<?= $slug ? $slug : 'login'; ?>">
