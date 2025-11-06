<?php

namespace App\Controllers;

use App\Model\Produto;
use App\Services\ServiceProduto;
use App\Helper\View;

class MovimentacaoController
{
    public function __construct() {}

    public function index()
    {
        $service = new ServiceProduto(new Produto());
        $produtos = $service->listarProdutos();

        $acao = 'movimentacoes';

        View::render('home', [
            'ultimasMovimentacoes' => $produtos,
            'acao' => $acao,
            'produtosBaixoEstoque' => $produtosBaixoEstoque ?? [],
        ]);
    }
}
