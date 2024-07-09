<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Transaction;

class GameController extends Controller
{
    // リセットページを表示する
    public function showResetPage()
    {
        return view('reset');
    }

    // ゲームをリセットする
    public function resetGame(Request $request)
    {
        // すべてのユーザーを削除
        User::query()->delete();

        // 銀行のユーザーを作成し、残高を100000に設定
        User::create([
            'name' => 'Bank',
            'balance' => 100000
        ]);

        // 税のユーザーを作成し、残高を0に設定
        User::create([
            'name' => 'Tax',
            'balance' => 0
        ]);

        // トランザクション履歴を削除する
        Transaction::query()->delete();

        return redirect()->route('home')->with('message', 'Game has been reset successfully.');
    }

    // 名前設定フォームを表示する
    public function showSetNameForm()
    {
        return view('set-name');
    }

    // 名前を設定する
    public function setName(Request $request)
    {
        // 入力されたプレイヤー名を検証する
        $request->validate([
            'player_name' => 'required|string|max:255',
        ]);

        // 入力されたプレイヤー名を取得
        $playerName = $request->input('player_name');

        // ユーザーが既に存在するか確認
        $user = User::firstOrCreate(
            ['name' => $playerName],
            ['balance' => 1500] // 初期バランスを設定
        );

        // セッションにプレイヤー名を保存する
        $request->session()->put('player_name', $user->name);

        return redirect()->route('send-money-form')->with('message', 'Player name has been set.');
    }
}
