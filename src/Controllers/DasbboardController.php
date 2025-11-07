<?php

namespace App\Controllers;

use App\Model\Produto;
use App\Model\Movimentacao;
use App\Services\ServiceProduto;
use App\Services\ServiceMovimentacao;
use App\Helper\View;

class DasbboardController
{
    public function __construct() {}

    public function index()
    {
        $service = new ServiceProduto(new Produto());
        $produtos = $service->listarProdutos();

        $serviceMovimentacoes = new ServiceMovimentacao(new Movimentacao());
        $movimentacoes =  $serviceMovimentacoes->listarMovimentacoesProdutos(1, 4);

        $acao = 'dashboard'; // ou algo vindo de $_GET['acao'] ?? 'dashboard';

        View::render('home', [
            'produtos' => $produtos,
            'ultimasMovimentacoes' => $movimentacoes,
            'acao' => $acao,
            'produtosBaixoEstoque' => $produtosBaixoEstoque ?? [],
        ]);
        exit;
    }
}
