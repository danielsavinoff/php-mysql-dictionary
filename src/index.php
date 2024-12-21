<?php
  declare(strict_types = 1);

  define(
    'STORAGE_PATH',  
    __DIR__ . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'dictionary'
  );
  define(
    'RESULT_PATH',  
    __DIR__ . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'library'
  );
  define(
    'LOGS_PATH',
    __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'logs'
  );

  require_once __DIR__ .
    DIRECTORY_SEPARATOR .
    'db' .
    DIRECTORY_SEPARATOR .
    'db.php';
  
  $db = new Database('', '', '', '', '', '');

  require_once __DIR__ . 
    DIRECTORY_SEPARATOR . 
    'helpers' . 
    DIRECTORY_SEPARATOR .
    'groupDictionary.php';

  if (php_sapi_name() === 'cli') {
    $options = getopt('D:L:');

    $D = isset($options['D']) ?
      __DIR__ . $options['D'] : 
      STORAGE_PATH . DIRECTORY_SEPARATOR . 'Russian.txt';
    
    $L = isset($options['L']) ?
      __DIR__ . $options['L'] 
      : RESULT_PATH;

    groupDictionary($D, $L);
  } else {
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'Router.php');
    
    $router = new Router();

    $router->get('/', function () {
      require_once(__DIR__ . '/app/Views/Home.php');
    });
    $router->post('/uploads', function () {
      require_once(__DIR__ . '/app/Controllers/Upload.php');
    });
    $router->get('/info', function () {
      echo phpinfo();
    });

    $router->dispatch();
  }
?>