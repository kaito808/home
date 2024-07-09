<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\GameController;

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

// ゲームのリセット
Route::get('/reset', [GameController::class, 'showResetPage'])->name('reset.show');
Route::post('/reset', [GameController::class, 'resetGame'])->name('reset.perform');

// ホームページ（名前設定フォームの表示）
Route::get('/', [GameController::class, 'showSetNameForm'])->name('home');
Route::post('/', [GameController::class, 'setName'])->name('set-name');

// お金を送るフォームの表示と送金処理
Route::get('/send-money', [TransactionController::class, 'showSendMoneyForm'])->name('send-money-form');
Route::post('/send-money', [TransactionController::class, 'sendMoney'])->name('send-money');