<?php

use Illuminate\Support\Facades\Route;
use PHPUnit\TextUI\XmlConfiguration\Group;
use App\Http\Middleware\LogAcessoMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\PrincipalController::class, 'principal'])->name('site.index');

Route::get('/sobre-nos', [\App\Http\Controllers\SobreNosController::class, 'sobreNos'])->name('site.sobrenos');

Route::get('/contato', [\App\Http\Controllers\ContatoController::class, 'contato'])->name('site.contato');
Route::post('/contato', [\App\Http\Controllers\ContatoController::class, 'salvar'])->name('site.contato');

Route::get('/login', function() { return 'Login'; })->name('site.login');

Route::prefix('/app')->group(function() {
    Route::middleware('log.acesso', 'autenticacao')
        ->get('/clientes', function() { return 'Clientes'; })
        ->name('app.clientes');

    Route::middleware('log.acesso', 'autenticacao')
        ->get('/fornecedores', [\App\Http\Controllers\FornecedorController::class, 'index'])
        ->name('app.fornecedores');

    Route::middleware('log.acesso', 'autenticacao')
        ->get('/produtos', function() { return 'Produtos'; })
        ->name('app.produtos');
});

Route::get('/teste/{p1}/{p2}', [\App\Http\Controllers\TesteController::class, 'teste'])->name('site.teste');

Route::fallback(function() {
    echo 'Recurso Não Localizado. <a href="'.route('site.index').'">Voltar para Página Inicial</a>';
});