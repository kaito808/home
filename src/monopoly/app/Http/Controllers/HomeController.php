<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $playerName = $request->session()->get('player_name');
        $user = $playerName ? User::where('name', $playerName)->first() : null;

        return view('home', compact('user'));
    }
}