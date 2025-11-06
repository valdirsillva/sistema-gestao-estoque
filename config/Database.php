<?php

namespace Config;

use PDO;
use PDOException;

// Configuração do Banco de Dados
class Database
{
  private $host = 'localhost';
  private $dbname = 'gerenciador_estoque';
  private $user = 'root';
  private $pass = '';
  private $conn;

  public function connect()
  {
    if ($this->conn === null) {
      try {
        $this->conn = new PDO(
          "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
          $this->user,
          $this->pass,
          [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
      } catch (PDOException $e) {
        die("Erro de conexão: " . $e->getMessage());
      }
    }
    return $this->conn;
  }
}
