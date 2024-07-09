<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Transaction;

class TransactionController extends Controller
{
    public function showSendMoneyForm(Request $request)
    {
        $users = User::all();
        $transactions = Transaction::orderBy('created_at', 'desc')->take(20)->get();
        $playerName = $request->session()->get('player_name');

        if (!$playerName) {
            return redirect()->route('home')->withErrors(['Player name not found in session.']);
        }

        $user = User::where('name', $playerName)->first();

        if (!$user) {
            return redirect()->route('home')->withErrors(['User not found.']);
        }

        return view('send-money', compact('users', 'transactions', 'user'));
    }

    public function sendMoney(Request $request)
    {
        $senderName = $request->input('sender_name');
        $receiverName = $request->input('receiver_name');
        $amount = intval($request->input('amount'));
        $transactionType = $request->input('transactionType');

        $sender = User::where('name', $senderName)->first();
        $receiver = User::where('name', $receiverName)->first();

        if (!$sender || !$receiver) {
            return redirect()->back()->withErrors(['User not found']);
        }

        switch ($transactionType) {
            case 'go':
                $amount = 200;
                break;
            case 'freeParking':
                $taxUser = User::where('name', 'Tax')->first();
                if ($taxUser) {
                    $amount = $taxUser->balance;
                    $taxUser->balance = 0;
                    $taxUser->save();
                }
                break;
            case 'luxuryTax':
                $amount = 75;
                $receiver = User::where('name', 'Tax')->first();
                break;
            case 'incomeTax':
                $receiver = User::where('name', 'Tax')->first();
                $amount = min(intval($sender->balance * 0.1), 200);
                break;
            default:
                break;
        }

        if ($amount <= 0) {
            return redirect()->back()->withErrors(['Invalid amount']);
        }

        $sender->balance -= $amount;
        $sender->save();

        $receiver->balance += $amount;
        $receiver->save();

        $transaction = new Transaction();
        $transaction->sender_id = $sender->id;
        $transaction->receiver_id = $receiver->id;
        $transaction->amount = $amount;
        $transaction->save();

        return redirect()->route('send-money-form')->with('message', 'Transaction successful');
    }
}
