<?php

use Illuminate\Support\Facades\Route;
use App\Mail\MensagemTesteMail;

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

Route::get('/', function () {
    return view('bem-vindo');
});

Auth::routes(['verify' => true]);

/*Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home')
    ->middleware('verified');*/

Route::get('tarefa/exportar/{extensao}', 'App\Http\Controllers\TarefaController@exportar')
    ->name('tarefa.exportar');

Route::get('tarefa/exportarpdf', 'App\Http\Controllers\TarefaController@exportarPdf')
    ->name('tarefa.exportar.pdf');

//Route::resource('tarefa', 'App\Http\Controllers\TarefaController')->middleware('auth');
Route::resource('tarefa', 'App\Http\Controllers\TarefaController')
    ->middleware('verified');

Route::get('/mail-teste', function() {
    return new MensagemTesteMail();
    //Mail::to('dcunhamaciel@gmail.com')->send(new MensagemTesteMail());    
    //return 'E-mail enviado com sucesso!';
});