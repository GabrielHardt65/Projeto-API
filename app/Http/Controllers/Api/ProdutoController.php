<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProdutoResource;
use App\Models\Produto;
use Illuminate\Http\Request;
use App\Http\Requests\ProdutoRequest;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProdutoResource::collection(Produto::latest()->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProdutoRequest $request)
    {
        $dados = $request->validated();

        $produto = Produto::create($dados);

        // Código 201 : Recurso Criado
        return new ProdutoResource($produto);
    }

    /**
     * Display the specified resource.
     */
    public function show(Produto $produto)
    {
        return new ProdutoResource($produto);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProdutoRequest $request, Produto $produto)
    {
        $dados = $request->validated();

        $produto->update($dados);

        return new ProdutoResource($produto);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produto $produto)
    {
        $produto->delete();
        return response()->noContent(); // 204
    }

    public function validarCusto(){
        // se tiver mais de uma regra de negocio a gente criar um outro negocio que o services por ser uma 
        // regra de negocio pode ser assim como esta aqui porem se tiver tipo 10 regras de negocio tem que usar 
    }
}
