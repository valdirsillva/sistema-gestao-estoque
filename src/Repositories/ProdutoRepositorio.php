<?php


namespace App\Repositories;

use App\Repositories\IProduto;
use Config\Database;
use PDO;

class ProdutoRepositorio implements IProduto
{
  public function __construct(private Database $database) {}

  public function listarTodos()
  {
    try {
      $conn = $this->database->connect();
      $stmt = $conn->prepare("SELECT * FROM produtos");
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
      die("Erro ao listar produtos: " . $e->getMessage());
    }
  }

  public function buscarPorId(int $id): ?array
  {
    try {
      $conn = $this->database->connect();
      $stmt = $conn->prepare("SELECT * FROM produtos WHERE id = :id");
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
      $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$resultado) {
        throw new \RuntimeException('Produto nao encontrado');
      }

      return $resultado;
    } catch (\PDOException $e) {
      throw new \RuntimeException("Produto nao encontrado" . $e->getMessage());
    }
  }

  public function criar(array $dados)
  {
    try {
      $conn = $this->database->connect();
      $stmt = $conn->prepare("INSERT INTO produtos (nome, descricao, preco, quantidade) VALUES (:nome, :descricao, :preco, :quantidade)");
      $stmt->bindParam(':nome', $dados['nome']);
      $stmt->bindParam(':descricao', $dados['descricao']);
      $stmt->bindParam(':preco', $dados['preco']);
      $stmt->bindParam(':quantidade', $dados['quantidade']);
      $stmt->execute();
      return $conn->lastInsertId();
    } catch (\PDOException $e) {
      die("Erro ao criar produto: " . $e->getMessage());
    }
  }

  public function atualizar($id, array $dados)
  {
    try {
      $conn = $this->database->connect();
      $stmt = $conn->prepare("UPDATE produtos SET nome = :nome, descricao = :descricao, preco = :preco, quantidade = :quantidade WHERE id = :id");
      $stmt->bindParam(':nome', $dados['nome']);
      $stmt->bindParam(':descricao', $dados['descricao']);
      $stmt->bindParam(':preco', $dados['preco']);
      $stmt->bindParam(':quantidade', $dados['quantidade']);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      return $stmt->execute();
    } catch (\PDOException $e) {
      die("Erro ao atualizar produto: " . $e->getMessage());
    }
  }

  public function deletar($id)
  {
    try {
      $conn = $this->database->connect();
      $stmt = $conn->prepare("DELETE FROM produtos WHERE id = :id");
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      return $stmt->execute();
    } catch (\PDOException $e) {
      die("Erro ao deletar produto: " . $e->getMessage());
    }
  }
}
