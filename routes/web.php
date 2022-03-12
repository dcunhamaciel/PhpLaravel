<?php

use Illuminate\Support\Facades\Route;
use PHPUnit\TextUI\XmlConfiguration\Group;

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

Route::get('/', [\App\Http\Controllers\PrincipalController::class, 'principal']);

Route::get('/sobre-nos', [\App\Http\Controllers\SobreNosController::class, 'sobreNos']);

Route::get('/contato', [\App\Http\Controllers\ContatoController::class, 'contato']);

Route::get('/login', function() { return 'Login'; });

Route::prefix('/app')->group(function() {
    Route::get('/clientes', function() { return 'Clientes'; });
    Route::get('/fornecedores', function() { return 'Fornecedores'; });
    Route::get('/produtos', function() { return 'Produtos'; });
});