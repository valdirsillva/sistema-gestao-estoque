<?php
require __DIR__ . '/vendor/autoload.php';

use App\Controllers\ProdutoController;

$controller = new ProdutoController();
$controller->index();
