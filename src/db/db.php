<?php
  declare(strict_types = 1);

  class Database {
    public $conn;

    public function __construct(
      string $database,
      string $hostname,
      string|int $port,
      string $name,
      string $user, 
      string $password
    )
    {
      try {
        $this->conn = new PDO(
          $database . ':' .
          'host=' . $hostname . ';' .
          'port=' . $port . ';' .
          'dbname=' . $name,
          $user,
          $password
        );
      } catch (PDOException $e) {
        if (!is_dir(LOGS_PATH)) {
          mkdir(LOGS_PATH);
        }

        $logsFileHandle = fopen(LOGS_PATH . DIRECTORY_SEPARATOR . 'mysql.log', 'a+');

        fwrite($logsFileHandle, '[' . date('Y-m-d H:i:s') . '] ' . $e->getMessage());

        fclose($logsFileHandle);
      }
    }
  }