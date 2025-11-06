<?php

namespace App\Repositories;

interface IProduto
{
  public function listarTodos();
  public function buscarPorId(int $id);
  public function criar(array $dados);
  public function atualizar($id, array $dados);
  public function deletar(int $id);
}
