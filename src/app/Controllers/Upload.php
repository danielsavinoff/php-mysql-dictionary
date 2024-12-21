<?php
  require_once __DIR__ . 
    DIRECTORY_SEPARATOR . 
    '..' . 
    DIRECTORY_SEPARATOR . 
    '..' . 
    DIRECTORY_SEPARATOR .
    'helpers' .
    DIRECTORY_SEPARATOR .
    'groupDictionary.php';

  if (empty($_FILES)) {
    http_response_code(400);

    exit();
  }

  foreach($_FILES as $file) {
    if ($file['type'] === 'text/plain') {
      $newPath = STORAGE_PATH . DIRECTORY_SEPARATOR . $file['name'];
      
      move_uploaded_file($file['tmp_name'], $newPath);

      groupDictionary($newPath, RESULT_PATH);
    }
  }