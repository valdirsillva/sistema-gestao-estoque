<?php

namespace App\Repositories;

interface IMotiventacao
{
  public function registrar();
  public function listar($limite = 50, $produto_id = null);
  public function relatorioMovimentacoes($dataInicio, $dataFim, $tipo = null);
}
