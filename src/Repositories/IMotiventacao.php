<?php

namespace App\Repositories;

interface IMotiventacao
{
  public function registrar(array $dados);
  public function listar($limite = 50, $produto_id = null);
  public function atualizarMovimentacoes(array $dados);
  public function relatorioMovimentacoes($dataInicio, $dataFim, $tipo = null);
}
