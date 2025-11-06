<?php

namespace App\Model;

use App\Repositories\ProdutoRepositorio;
use Config\Database;

class Produto
{
  private ProdutoRepositorio $produtoRepositorio;

  public function __construct()
  {
    $this->produtoRepositorio = new ProdutoRepositorio(new Database());
  }
  public function listarProdutos(): array
  {
    return $this->produtoRepositorio->listarTodos();
  }

  public function buscarProdutoPorId(int $id): ?array
  {
    return $this->produtoRepositorio->buscarPorId($id);
  }

  public function criarProduto(array $dados)
  {
    return $this->produtoRepositorio->criar($dados);
  }

  public function atualizarProduto($id, array $dados)
  {
    return $this->produtoRepositorio->atualizar($id, $dados);
  }

  public function deletarProduto(int $id)
  {
    return $this->produtoRepositorio->deletar($id);
  }
}
