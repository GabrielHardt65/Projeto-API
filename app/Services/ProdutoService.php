<?php

namespace App\Services;

use Illuminate\Validation\ValidationException as ValidationValidationException;
use Illuminate\Validation\ValidationException;
use App\Models\Produto;

class ProdutoService
{
    private const MARGEM_MINIMA = 0.10;

    public function create(array $dados)
    {
        $this->verificarMargem($dados['preco'], $dados ['preco_custo']);

        return Produto::create($dados);

    }

    private function verificarMargem(float $preco, float $preco_custo)

    {
        // O preço mínimo de um produto deve ser
        // maior ou igual a mais 10% do valor de custo
        $margem = $preco_custo + ($preco_custo * self::MARGEM_MINIMA);
        $minimo = round($margem, 2);

        if($preco < $minimo){
            throw ValidationException::withMessages([
                'preco' => sprintf('O preco do produto deve ser no mínimo %. 2f (Margem Mínima)', $minimo),
            ]);
        }

    }
}