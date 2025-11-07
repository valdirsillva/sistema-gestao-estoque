<aside class="sidebar">
  <div class="logo">📦 Gestão Estoque</div>
  <a href="?acao=dashboard" class="menu-item <?= $acao === 'dashboard' ? 'active' : '' ?>">
    📊 Dashboard
  </a>
  <a href="?acao=produtos" class="menu-item <?= $acao === 'produtos' ? 'active' : '' ?>">
    📦 Produtos
  </a>
  <a href="?acao=movimentacoes" class="menu-item <?= $acao === 'movimentacoes' ? 'active' : '' ?>">
    🔄 Movimentações
  </a>
  <a href="?acao=relatorios" class="menu-item <?= $acao === 'relatorios' ? 'active' : '' ?>">
    📈 Relatórios
  </a>
  <a href="?acao=alertas" class="menu-item <?= $acao === 'alertas' ? 'active' : '' ?>">
    🔔 Alertas (<?= count($produtosBaixoEstoque) ?>)
  </a>
</aside>