<?php

namespace App\Model;

use App\Repositories\MovimentacaoRepositorio;
use Config\Database;

class Movimentacao
{
  private MovimentacaoRepositorio $movimentacaoRepositorio;

  public function __construct()
  {
    $this->movimentacaoRepositorio = new MovimentacaoRepositorio(new Database());
  }

  public function registrar(array $dados)
  {
    return $this->movimentacaoRepositorio->registrar($dados);
  }

  public function listar($limite = 50, $produto_id = null)
  {
    return $this->movimentacaoRepositorio->listar($limite, $produto_id);
  }

  public function relatorioMovimentacoes($dataInicio, $dataFim, $tipo = null)
  {
    return $this->movimentacaoRepositorio->relatorioMovimentacoes($dataInicio, $dataFim, $tipo);
  }
}
