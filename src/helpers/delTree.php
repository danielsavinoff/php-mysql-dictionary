<?php
  declare(strict_types = 1);

  function delTree(string $dir) {
    $files = array_diff(scandir($dir), array('.','..'));
 
    foreach ($files as $file) {
      (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
    }
 
    return rmdir($dir);
  }