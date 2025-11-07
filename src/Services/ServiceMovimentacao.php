<?php

namespace App\Services;

use App\Model\Movimentacao;

class ServiceMovimentacao
{
  public function __construct(private Movimentacao $movimentacao) {}

  public function listarMovimentacoesProdutos($limite, $produto_id)
  {
    return $this->movimentacao->listar($limite, $produto_id);
  }
}
