<?php
declare(strict_types=1);

define('HOME_DIR', dirname(__DIR__) . '/');
define('HTDOCS_DIR', HOME_DIR . 'htdocs/');
define('CONFIG_DIR', HOME_DIR . 'config/');
define('LIBRARY_DIR', HOME_DIR . 'library/');
define('TEMPLATE_DIR', HOME_DIR . 'template/');

require_once(CONFIG_DIR . "config.php");
spl_autoload_register(function ($class) {
  $prefix = 'TypingApp\\';
  if (strpos($class, $prefix) === 0) {
    $fileDir = sprintf(LIBRARY_DIR . '%s.php', substr($class, strlen($prefix)));
    if (file_exists($fileDir)) {
      require($fileDir);
    } else {
      echo 'File not found: ' . $fileDir;
      exit;
    }
  }
});