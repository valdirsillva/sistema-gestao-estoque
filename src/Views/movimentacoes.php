<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema de Gestão de Estoque - Pagina Movimentações</title>
  <link rel="stylesheet" href="/sistema-gestao-estoque/src/Views/css/style.css">
  <!-- <link rel="stylesheet" href="/sistema-gestao-estoque/src/Views/css/modal.css"> -->
</head>

<body>
  <div class="container">
    <!-- Sidebar -->
    <?php require __DIR__ . '/sidebar/menu-sidebar.php' ?>

    <!-- Main Content -->
    <main class="main-content">
      <div class="header">
        <h1>Movimentações</h1>
        <span><?= date('d/m/Y H:i') ?></span>
      </div>
    </main>
  </div>

  <div class="demo-container">
    <div class="demo-info">
      <h3>🎯 Demonstração dos Modais</h3>
      <p>Clique nos botões abaixo para testar os modais do sistema de gestão de estoque.</p>
    </div>

    <div class="demo-buttons">
      <button class="btn btn-primary" onclick="abrirModal('modalProduto')">
        ➕ Novo Produto
      </button>
      <button class="btn btn-success" onclick="abrirModal('modalMovimentacao')">
        🔄 Nova Movimentação
      </button>
    </div>

    <!-- Modal Novo Produto -->
    <div id="modalProduto" class="modal-overlay" onclick="fecharModalClick(event, 'modalProduto')">
      <div class="modal" onclick="event.stopPropagation()">
        <div class="modal-header">
          <h2 class="modal-title">📦 Novo Produto</h2>
          <button class="modal-close" onclick="fecharModal('modalProduto')">&times;</button>
        </div>

        <form id="formProduto" onsubmit="salvarProduto(event)">
          <div class="modal-body">
            <div class="alert alert-info">
              ℹ️ Preencha os dados do novo produto para adicionar ao estoque.
            </div>

            <div class="form-group">
              <label class="form-label required">Código do Produto</label>
              <input type="text" name="codigo" class="form-control" placeholder="Ex: PROD001" required>
            </div>

            <div class="form-group">
              <label class="form-label required">Nome do Produto</label>
              <input type="text" name="nome" class="form-control" placeholder="Ex: Notebook Dell Inspiron" required>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label class="form-label required">Quantidade Inicial</label>
                <input type="number" name="quantidade" class="form-control" placeholder="0" min="0" required>
              </div>

              <div class="form-group">
                <label class="form-label required">Quantidade Mínima</label>
                <input type="number" name="quantidade_minima" class="form-control" placeholder="5" min="1" required>
              </div>
            </div>

            <div class="form-group">
              <label class="form-label required">Preço Unitário (R$)</label>
              <input type="number" name="preco" class="form-control" placeholder="0,00" step="0.01" min="0" required>
            </div>

            <div class="form-group">
              <label class="form-label">Descrição</label>
              <textarea name="descricao" class="form-control" placeholder="Descrição detalhada do produto (opcional)"></textarea>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="fecharModal('modalProduto')">
              Cancelar
            </button>
            <button type="submit" class="btn btn-primary">
              💾 Salvar Produto
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Modal Nova Movimentação -->
    <div id="modalMovimentacao" class="modal-overlay" onclick="fecharModalClick(event, 'modalMovimentacao')">
      <div class="modal" onclick="event.stopPropagation()">
        <div class="modal-header">
          <h2 class="modal-title">🔄 Nova Movimentação</h2>
          <button class="modal-close" onclick="fecharModal('modalMovimentacao')">&times;</button>
        </div>

        <form id="formMovimentacao" onsubmit="salvarMovimentacao(event)">
          <div class="modal-body">
            <div class="alert alert-info">
              ℹ️ Registre entradas ou saídas de produtos do estoque.
            </div>

            <div class="form-group">
              <label class="form-label required">Produto</label>
              <select name="produto_id" class="form-control" required onchange="atualizarEstoqueAtual(this)">
                <option value="">Selecione um produto...</option>
                <option value="1" data-estoque="50">Notebook Gamer - Estoque: 50 un.</option>
                <option value="2" data-estoque="30">Mouse Logitech - Estoque: 30 un.</option>
                <option value="3" data-estoque="15">Teclado Mecânico - Estoque: 15 un.</option>
                <option value="4" data-estoque="8">Monitor LG 27" - Estoque: 8 un.</option>
                <option value="5" data-estoque="3">Webcam HD - Estoque: 3 un.</option>
              </select>
            </div>

            <div id="estoqueAtualInfo" class="alert alert-success" style="display: none;">
              📊 Estoque atual: <strong id="estoqueAtualValor">0</strong> unidades
            </div>

            <div class="form-group">
              <label class="form-label required">Tipo de Movimentação</label>
              <div class="radio-group">
                <label class="radio-option">
                  <input type="radio" name="tipo" value="entrada" checked>
                  <span>📥 Entrada</span>
                </label>
                <label class="radio-option">
                  <input type="radio" name="tipo" value="saida">
                  <span>📤 Saída</span>
                </label>
              </div>
            </div>

            <div class="form-group">
              <label class="form-label required">Quantidade</label>
              <input type="number" name="quantidade" class="form-control" placeholder="0" min="1" required>
            </div>

            <div class="form-group">
              <label class="form-label required">Usuário Responsável</label>
              <input type="text" name="usuario" class="form-control" placeholder="Ex: João Silva" required>
            </div>

            <div class="form-group">
              <label class="form-label">Observação</label>
              <textarea name="observacao" class="form-control" placeholder="Motivo da movimentação, fornecedor, etc. (opcional)"></textarea>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="fecharModal('modalMovimentacao')">
              Cancelar
            </button>
            <button type="submit" class="btn btn-success">
              ✅ Confirmar Movimentação
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    // Funções para abrir e fechar modais
    function abrirModal(modalId) {
      const modal = document.getElementById(modalId);
      if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden'; // Previne scroll do body
      }
    }

    function fecharModal(modalId) {
      const modal = document.getElementById(modalId);
      if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = ''; // Restaura scroll do body

        // Limpa o formulário
        const form = modal.querySelector('form');
        if (form) {
          form.reset();
        }

        // Esconde info de estoque
        const estoqueInfo = document.getElementById('estoqueAtualInfo');
        if (estoqueInfo) {
          estoqueInfo.style.display = 'none';
        }
      }
    }

    function fecharModalClick(event, modalId) {
      if (event.target.classList.contains('modal-overlay')) {
        fecharModal(modalId);
      }
    }

    // Fecha modal com ESC
    document.addEventListener('keydown', function(event) {
      if (event.key === 'Escape') {
        const modaisAtivos = document.querySelectorAll('.modal-overlay.active');
        modaisAtivos.forEach(modal => {
          fecharModal(modal.id);
        });
      }
    });

    // Atualiza informação de estoque atual
    function atualizarEstoqueAtual(select) {
      const estoqueInfo = document.getElementById('estoqueAtualInfo');
      const estoqueValor = document.getElementById('estoqueAtualValor');

      if (select.value) {
        const selectedOption = select.options[select.selectedIndex];
        const estoque = selectedOption.getAttribute('data-estoque');

        estoqueValor.textContent = estoque;
        estoqueInfo.style.display = 'flex';
      } else {
        estoqueInfo.style.display = 'none';
      }
    }

    // Função para salvar produto (demonstração)
    function salvarProduto(event) {
      event.preventDefault();

      const formData = new FormData(event.target);
      const dados = Object.fromEntries(formData);

      console.log('📦 Novo Produto:', dados);

      alert('✅ Produto cadastrado com sucesso!\n\n' +
        'Código: ' + dados.codigo + '\n' +
        'Nome: ' + dados.nome + '\n' +
        'Quantidade: ' + dados.quantidade + '\n' +
        'Preço: R$ ' + parseFloat(dados.preco).toFixed(2));

      fecharModal('modalProduto');
    }

    // Função para salvar movimentação (demonstração)
    function salvarMovimentacao(event) {
      event.preventDefault();

      const formData = new FormData(event.target);
      const dados = Object.fromEntries(formData);

      const select = event.target.querySelector('[name="produto_id"]');
      const produtoNome = select.options[select.selectedIndex].text.split(' - ')[0];
      console.log('🔄 Nova Movimentação:', dados);

      const tipoEmoji = dados.tipo === 'entrada' ? '📥' : '📤';
      const tipoTexto = dados.tipo === 'entrada' ? 'Entrada' : 'Saída';

      alert('✅ Movimentação registrada com sucesso!\n\n' +
        tipoEmoji + ' Tipo: ' + tipoTexto + '\n' +
        'Produto: ' + produtoNome + '\n' +
        'Quantidade: ' + dados.quantidade + '\n' +
        'Usuário: ' + dados.usuario);

      fecharModal('modalMovimentacao');
    }
  </script>

</body>

</html>