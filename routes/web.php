<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProdottoController;





// con il path vuoto reindirizza alla login
Route::get('/', function () {
    return view('login/login');
})->name('login');

//rotta fatto il login vai alla dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('home');

//al path login ti reindirizza login post
Route::post('/login', [AuthManager::class, 'loginPost'])->name('login.post');


Route::get('/register', [AuthManager::class, 'register'])->name('register');
Route::post('/register', [AuthManager::class, 'registerPost'])->name('register.post');

//rotta per il logout
Route::get('/logout',[AuthManager::class, 'logout'])->name('logout');

//rotte per la crud categoria
Route::get('/categorie', [CategoriaController::class, 'index' ])->name('categoria');
Route::get('/categorie/create', [CategoriaController::class, 'create' ])->name('categoria.create');
Route::get('/categorie/{categoria}/edit', [CategoriaController::class, 'edit' ])->name('categoria.edit');
Route::post('/categorie/store', [CategoriaController::class, 'store' ])->name('categoria.store');
Route::delete('/categorie/{categoria}', [CategoriaController::class, 'destroy'])->name('categoria.destroy');
Route::put('/categorie/{categoria}', [CategoriaController::class, 'update'])->name('categoria.update');

//rotte per la crud di prodotto
Route::get('prodotti',[ProdottoController::class, 'index'])->name('prodotto');
Route::get('prodotti/create',[ProdottoController::class,'create'])->name('prodotto.create');
Route::post('/prodotti/store', [ProdottoController::class, 'store' ])->name('prodotto.store');
Route::get('/prodotti/{prodotto}/edit', [ProdottoController::class, 'edit' ])->name('prodotto.edit');
Route::delete('/prodotti/{prodotto}', [ProdottoController::class, 'destroy'])->name('prodotto.destroy');
Route::put('/prodotti/{prodotto}', [ProdottoController::class, 'update'])->name('prodotto.update');




