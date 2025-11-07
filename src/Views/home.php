<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema de Gestão de Estoque - Pagina Home</title>
  <link rel="stylesheet" href="/sistema-gestao-estoque/src/Views/css/style.css">

</head>

<body>
  <div class="container">
    <!-- Sidebar -->
    <?php require __DIR__ . '/sidebar/menu-sidebar.php' ?>

    <!-- Main Content -->
    <main class="main-content">
      <?php if (isset($mensagem)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($mensagem) ?></div>
      <?php endif; ?>

      <?php if ($acao === 'dashboard'): ?>
        <!-- Dashboard -->
        <div class="header">
          <h1>Dashboard</h1>
          <span><?= date('d/m/Y H:i') ?></span>
        </div>

        <div class="cards-grid">
          <div class="card">
            <div class="card-header">
              <div>
                <div class="card-title">Total de Produtos</div>
                <div class="card-value"><?= count($produtos) ?></div>
              </div>
              <div class="card-icon" style="background: #e3f2fd;">📦</div>
            </div>
          </div>

          <div class="card">
            <div class="card-header">
              <div>
                <div class="card-title">Valor Total</div>
                <div class="card-value">R$ <?= number_format(array_sum(array_map(fn($p) => $p['quantidade'] * $p['preco'], $produtos)), 2, ',', '.') ?></div>
              </div>
              <div class="card-icon" style="background: #e8f5e9;">💰</div>
            </div>
          </div>

          <div class="card">
            <div class="card-header">
              <div>
                <div class="card-title">Produtos Baixo Estoque</div>
                <div class="card-value status-critico"><?= count($produtosBaixoEstoque) ?></div>
              </div>
              <div class="card-icon" style="background: #ffebee;">⚠️</div>
            </div>
          </div>

          <div class="card">
            <div class="card-header">
              <div>
                <div class="card-title">Movimentações Hoje</div>
                <div class="card-value"><?= count(array_filter($ultimasMovimentacoes, fn($m) => date('Y-m-d', strtotime($m['data_movimentacao'])) === date('Y-m-d'))) ?></div>
              </div>
              <div class="card-icon" style="background: #fff3e0;">🔄</div>
            </div>
          </div>
        </div>

        <div class="table-container">
          <h2 style="margin-bottom: 20px;">Últimas Movimentações</h2>
          <table>
            <thead>
              <tr>
                <th>Data</th>
                <th>Produto</th>
                <th>Tipo</th>
                <th>Quantidade</th>
                <th>Usuário</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($ultimasMovimentacoes as $mov): ?>
                <tr>
                  <td><?= date('d/m/Y H:i', strtotime($mov['data_movimentacao'])) ?></td>
                  <td><?= htmlspecialchars($mov['produto_nome']) ?></td>
                  <td>
                    <span class="badge <?= $mov['tipo'] === 'entrada' ? 'badge-success' : 'badge-info' ?>">
                      <?= $mov['tipo'] === 'entrada' ? '📥 Entrada' : '📤 Saída' ?>
                    </span>
                  </td>
                  <td><?= $mov['quantidade'] ?></td>
                  <td><?= htmlspecialchars($mov['usuario']) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

      <?php elseif ($acao === 'produtos'): ?>
        <!-- Produtos -->
        <div class="header">
          <h1>Gestão de Produtos</h1>
          <button class="btn btn-primary" onclick="abrirModal('modalProduto')">➕ Novo Produto</button>
        </div>

        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>Código</th>
                <th>Nome</th>
                <th>Quantidade</th>
                <th>Mín.</th>
                <th>Preço</th>
                <th>Status</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($produtos as $produto):
                $status = $produto['quantidade'] > $produto['quantidade_minima'] ? 'ok' : ($produto['quantidade'] > 0 ? 'baixo' : 'critico');
              ?>
                <tr>
                  <td><strong><?= htmlspecialchars($produto['codigo']) ?></strong></td>
                  <td><?= htmlspecialchars($produto['nome']) ?></td>
                  <td><strong><?= $produto['quantidade'] ?></strong></td>
                  <td><?= $produto['quantidade_minima'] ?></td>
                  <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                  <td>
                    <span class="status-<?= $status ?>">
                      <?= $status === 'ok' ? '✅ OK' : ($status === 'baixo' ? '⚠️ Baixo' : '❌ Crítico') ?>
                    </span>
                  </td>
                  <td>
                    <button class="btn btn-primary" style="padding: 6px 12px;" onclick="abrirMovimentacao(<?= $produto['id'] ?>)">
                      ➕/➖
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

      <?php elseif ($acao === 'movimentacoes'): ?>
        <!-- Movimentações -->
        <div class="header">
          <h1>Movimentações de Estoque</h1>
          <button class="btn btn-success" onclick="abrirModal('modalMovimentacao')">➕ Nova Movimentação</button>
        </div>

        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>Data/Hora</th>
                <th>Produto</th>
                <th>Tipo</th>
                <th>Quantidade</th>
                <th>Usuário</th>
                <th>Observação</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($movimentacaoModel->listar(50) as $mov): ?>
                <tr>
                  <td>#<?= $mov['id'] ?></td>
                  <td><?= date('d/m/Y H:i', strtotime($mov['data_movimentacao'])) ?></td>
                  <td><?= htmlspecialchars($mov['produto_nome']) ?></td>
                  <td>
                    <span class="badge <?= $mov['tipo'] === 'entrada' ? 'badge-success' : 'badge-info' ?>">
                      <?= $mov['tipo'] === 'entrada' ? '📥 Entrada' : '📤 Saída' ?>
                    </span>
                  </td>
                  <td><strong><?= $mov['quantidade'] ?></strong></td>
                  <td><?= htmlspecialchars($mov['usuario']) ?></td>
                  <td><?= htmlspecialchars($mov['observacao']) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

      <?php elseif ($acao === 'alertas'): ?>
        <!-- Alertas -->
        <div class="header">
          <h1>Alertas de Estoque Baixo</h1>
        </div>

        <?php if (count($produtosBaixoEstoque) > 0): ?>
          <div class="alert alert-danger">
            ⚠️ <strong><?= count($produtosBaixoEstoque) ?> produto(s)</strong> com estoque abaixo do mínimo!
          </div>

          <div class="table-container">
            <table>
              <thead>
                <tr>
                  <th>Código</th>
                  <th>Produto</th>
                  <th>Quantidade Atual</th>
                  <th>Quantidade Mínima</th>
                  <th>Status</th>
                  <th>Ação</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($produtosBaixoEstoque as $produto): ?>
                  <tr>
                    <td><strong><?= htmlspecialchars($produto['codigo']) ?></strong></td>
                    <td><?= htmlspecialchars($produto['nome']) ?></td>
                    <td><strong class="status-critico"><?= $produto['quantidade'] ?></strong></td>
                    <td><?= $produto['quantidade_minima'] ?></td>
                    <td>
                      <span class="badge badge-danger">
                        <?= $produto['quantidade'] == 0 ? '🚫 ESGOTADO' : '⚠️ BAIXO' ?>
                      </span>
                    </td>
                    <td>
                      <button class="btn btn-success" style="padding: 6px 12px;" onclick="abrirMovimentacao(<?= $produto['id'] ?>)">
                        Repor Estoque
                      </button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php else: ?>
          <div class="alert alert-success">
            ✅ Todos os produtos estão com estoque adequado!
          </div>
        <?php endif; ?>

      <?php endif; ?>
    </main>
  </div>

</body>

</html>