<?php

namespace App\Controllers;

use App\Model\Produto;
use App\Services\ServiceProduto;
use App\Helper\View;

class ProdutoController
{
    public function __construct() {}

    public function index()
    {
        $service = new ServiceProduto(new Produto());
        $produtos = $service->listarProdutos();

        $acao = 'dashboard'; // ou algo vindo de $_GET['acao'] ?? 'dashboard';

        View::render('home', [
            'produtos' => $produtos,
            'acao' => $acao,
            'produtosBaixoEstoque' => $produtosBaixoEstoque ?? [],
        ]);
    }
}
