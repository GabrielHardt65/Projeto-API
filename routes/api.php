<?php

use App\Http\Controllers\Api\ProdutoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('/produtos', ProdutoController::class);