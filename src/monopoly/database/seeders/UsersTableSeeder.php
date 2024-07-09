<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $players = [
        ['name' => 'かいと', 'email' => 'player1@example.com', 'password' => Hash::make('password'), 'balance' => 1500],
        ['name' => 'ゆうと', 'email' => 'player2@example.com', 'password' => Hash::make('password'), 'balance' => 1500],
        ['name' => 'けんた', 'email' => 'player3@example.com', 'password' => Hash::make('password'), 'balance' => 1500],
        ['name' => 'はるき', 'email' => 'player4@example.com', 'password' => Hash::make('password'), 'balance' => 1500],
        ['name' => 'Player5', 'email' => 'player5@example.com', 'password' => Hash::make('password'), 'balance' => 1500],
        ['name' => 'Bank', 'email' => 'bank@example.com', 'password' => Hash::make('password'), 'balance' => 100000],
        ['name' => 'Tax', 'email' => 'tax@example.com', 'password' => Hash::make('password'), 'balance' => 0],
      ];

      foreach ($players as $player) {
          User::create($player);
      }
    }
}
