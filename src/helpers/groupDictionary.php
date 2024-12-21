<?php 
  declare(strict_types = 1);

  require_once __DIR__ . 
    DIRECTORY_SEPARATOR . 
    '..' .
    DIRECTORY_SEPARATOR .
    'helpers' . 
    DIRECTORY_SEPARATOR .
    'delTree.php';

  // Remove execution limit for a long-running process.
  set_time_limit(0);

  function groupDictionary(string $dictionaryPath, string $libraryPath) {
    // Open file in a stream and allocate only limited amount of memory
    // Instead of reading it at once and getting memory overflow.
    $dictionaryFileHandle = fopen($dictionaryPath, 'rt');
    $dictionaryFilename = pathinfo($dictionaryPath)['filename'];

    $libraryPathByDictionaryName = $libraryPath . DIRECTORY_SEPARATOR . $dictionaryFilename;
    
    if (is_dir($libraryPathByDictionaryName)) {
      deltree($libraryPathByDictionaryName);
    }
    
    mkdir($libraryPathByDictionaryName);

    $wordsFileHandle = null;
    $previousLetter = '';

    while (($line = fgets($dictionaryFileHandle))) {
      // Read first letter by mb_substr() because $line[0] would return the first byte
      // and not the first character.
      $firstLetter = mb_substr($line, 0, 1);
      $occurences = substr_count($line, $firstLetter);
      
      $path = $libraryPathByDictionaryName . DIRECTORY_SEPARATOR . $firstLetter;
      
      if (!is_dir($path)) {
        mkdir($path);
      }
      
      $counterPath = $path . DIRECTORY_SEPARATOR . 'count.txt';
      $wordsPath = $path . DIRECTORY_SEPARATOR . 'words.txt';
      
      // Optimization to reduce file openings.
      if (!($previousLetter) || !mb_stristr($firstLetter, $previousLetter)) {
        if (isset($wordsFileHandle)) {
          fclose($wordsFileHandle);
        }

        $wordsFileHandle = fopen($wordsPath, 'a+');

        $previousLetter = $firstLetter;

        file_put_contents($counterPath, 0);
      }

      // Makes it extremely slower but is a compromise
      // between speed and memory in case words are not groupped by letter.
      // Possible solution to use a hash table but if a file consists
      // of 1500-2000 letters it'd be less memory efficient.
      $count = file_get_contents($counterPath) + $occurences;
      file_put_contents($counterPath, $count);

      fwrite($wordsFileHandle, $line);
    }

    fclose($dictionaryFileHandle);
    fclose($wordsFileHandle);
  }
  