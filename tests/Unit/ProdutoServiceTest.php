<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Produto;
use App\Services\ProdutoService;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProdutoServiceTest extends TestCase
{
    use RefreshDatabase;

    private ProdutoService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ProdutoService();
    }

    public function test_produto_nao_cria_se_preco_abaixo_da_margem_minima(): void
    {
        $this->expectException(ValidationException::class);

        $dados = [
            'nome' => 'Produto Invalido',
            'preco_custo' => 100.00,
            'preco' => 105.00
        ];

        $this->service->create($dados);
    }

    public function test_atualiza_produto_com_sucesso(): void
    {
        $produto = Produto::create([
            'nome' => 'Produto Valido',
            'preco_custo' => 100.00,
            'preco' => 120.00
        ]);

        $novosDados = [
            'preco' => 130.00
        ];

        $produtoAtualizado = $this->service->update($produto, $novosDados);

        $this->assertEquals(130.00, $produtoAtualizado->preco);
        $this->assertDatabaseHas('produtos', [
            'id' => $produto->id,
            'preco' => 130.00
        ]);
    }

    public function test_update_falha_se_novo_preco_violar_margem_minima(): void
    {
        $this->expectException(ValidationException::class);

        $produto = Produto::create([
            'nome' => 'Produto Valido',
            'preco_custo' => 100.00,
            'preco' => 120.00
        ]);

        $this->service->update($produto, ['preco' => 102.00]);
    }
}