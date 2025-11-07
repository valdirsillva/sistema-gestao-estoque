<?php

namespace App\Repositories;

use Config\Database;
use PDO;

class MovimentacaoRepositorio implements IMotiventacao
{
  public function __construct(private Database $database) {}

  public function registrar(array $dados): bool
  {
    $conn = $this->database->connect();
    $conn->beginTransaction();
    try {
      $sql = "INSERT INTO movimentacoes (
        produto_id, tipo, quantidade, observacao, usuario
      ) 
      VALUES 
      (:produto_id, :tipo, :quantidade, :observacao, :usuario)";
      $stmt = $conn->prepare($sql);
      $stmt->execute($dados);

      $this->atualizarMovimentacoes($dados);

      $conn->commit();
      return true;
    } catch (\PDOException $e) {
      $conn->rollBack();
      throw new \RuntimeException("Erro ao listar os produtos");
      return false;
    }
  }
  public function listar($limite = 50, $produto_id = null)
  {
    try {
      $conn = $this->database->connect();
      $sql = "SELECT m.*, p.nome as produto_nome 
                FROM movimentacoes m 
                JOIN produtos p ON m.produto_id = p.id";

      if ($produto_id) {
        $sql .= " WHERE m.produto_id = :produto_id";
      }

      $sql .= " ORDER BY m.data_movimentacao DESC LIMIT :limite";
      $stmt = $conn->prepare($sql);

      if ($produto_id) {
        $stmt->bindValue(':produto_id', $produto_id, PDO::PARAM_INT);
      }

      $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
      $stmt->execute();

      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
      throw new \RuntimeException("Erro ao tentar listar produtos");
    }
  }
  public function atualizarMovimentacoes(array $dados)
  {
    try {
      $conn = $this->database->connect();
      $multiplicador = $dados['tipo'] === 'entrada' ? 1 : -1;
      $sqlUpdate = "UPDATE produtos SET quantidade = quantidade + :quantidade WHERE id = :produto_id";
      $stmtUpdate =  $conn->prepare($sqlUpdate);
      $stmtUpdate->execute([
        'quantidade' => $dados['quantidade'] * $multiplicador,
        'produto_id' => $dados['produto_id']
      ]);
    } catch (\PDOException $e) {
      throw new \RuntimeException("Erro ao tentar atualizar produtos");
    }
  }
  public function relatorioMovimentacoes($dataInicio, $dataFim, $tipo = null)
  {
    try {
      $conn = $this->database->connect();
      $sql = "SELECT m.*, p.nome as produto_nome, p.codigo as produto_codigo 
                FROM movimentacoes m 
                JOIN produtos p ON m.produto_id = p.id 
                WHERE DATE(m.data_movimentacao) BETWEEN :inicio AND :fim";

      if ($tipo) {
        $sql .= " AND m.tipo = :tipo";
      }

      $sql .= " ORDER BY m.data_movimentacao DESC";
      $stmt = $conn->prepare($sql);
      $stmt->bindValue(':inicio', $dataInicio);
      $stmt->bindValue(':fim', $dataFim);

      if ($tipo) {
        $stmt->bindValue(':tipo', $tipo);
      }

      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
      throw new \RuntimeException("Erro ao tentar listar produtos");
    }
  }
}
