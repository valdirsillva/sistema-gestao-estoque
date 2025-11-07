<?php

namespace App\Controllers;

use App\Model\Movimentacao;
use App\Services\ServiceMovimentacao;
use App\Helper\View;

class MovimentacaoController
{
    public function __construct() {}

    public function index()
    {
        $service = new ServiceMovimentacao(new Movimentacao());
        $movimentacoes = $service->listarMovimentacoesProdutos(10, 4);
        $acao = 'movimentacoes';
        View::render('movimentacoes', [
            'ultimasMovimentacoes' => $movimentacoes,
            'acao' => $acao,
            'produtosBaixoEstoque' => $produtosBaixoEstoque ?? [],
        ]);
        exit;
    }
}
