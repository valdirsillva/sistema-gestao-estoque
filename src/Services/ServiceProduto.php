<?php

namespace App\Services;

use App\Model\Produto;

class ServiceProduto
{
  public function __construct(private Produto $produto) {}

  public function listarProdutos()
  {
    return $this->produto->listarProdutos();
  }
}
