
<?php

use PHPUnit\Framework\TestCase;
use App\Model\Produto;

class ProdutoTest extends TestCase
{
  private Produto $produto;

  protected function setUp(): void
  {
    $this->produto = new Produto();
  }

  public function testPodeInstanciarProduto(): void
  {
    $this->assertInstanceOf(
      Produto::class,
      $this->produto,
      'Deve ser possível instanciar a classe Produto'
    );
  }

  public function testPossuiMetodoListarProdutos(): void
  {
    $this->assertTrue(
      method_exists($this->produto, 'listarProdutos'),
      'O método listarProdutos() deve existir'
    );

    $this->assertIsArray(
      $this->produto->listarProdutos(),
      'O método listarProdutos() deve retornar um array'
    );
  }

  public function testRetornoProdutoPorId(): void
  {
    $produto = $this->produto->buscarProdutoPorId(1);
    $this->assertNotNull($produto, 'Deve retornar um produto para o id fornecido');
    $this->assertNotNull($produto, 'O retorno deve ser um array');
  }

  public function testRetornoQuandoProdutoNaoExiste(): void
  {
    $this->expectException(RuntimeException::class);
    $this->expectExceptionMessage('Produto nao encontrado');
    $this->produto->buscarProdutoPorId(10);
  }

  public function testCriarProduto()
  {
    $resultado = $this->produto->criarProduto([
      'nome' => 'Notebook Gamer',
      'preco' => 7500.00,
      'descricao' => 'RTX 4070 e i9',
      'quantidade' => 15
    ]);

    $this->assertEquals(true, $resultado);
  }

  public function testAtualizarProduto()
  {
    $resultado = $this->produto->atualizarProduto(1, ['preco' => 6999.90]);
    $this->assertTrue($resultado);
  }

  public function testDeletarProduto()
  {
    $resultado = $this->produto->deletarProduto(10);
    $this->assertTrue($resultado);
  }
}
