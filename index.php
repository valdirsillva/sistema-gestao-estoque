<?php
require __DIR__ . '/vendor/autoload.php';

use App\Controllers\DasbboardController;
use App\Controllers\MovimentacaoController;
use App\Controllers\ProdutoController;

/**
 * Captura a ação da URL ou define o padrão
 * 
 */
$acao = $_GET['acao'] ?? 'dashboard';

// 🔹 Decide qual controller chamar com base na ação
switch ($acao) {
  case 'dashboard':
  default:
    (new DasbboardController())->index();
    break;
  case 'movimentacoes':
    (new MovimentacaoController())->index();
    break;
  case 'produtos':
    (new ProdutoController())->index();
    break;
}
