<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // database/migrations/xxxx_xx_xx_create_users_table.php
        Schema::create('transactions', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('sender_id')->unsigned();
          $table->integer('receiver_id')->unsigned();
          $table->decimal('amount', 8, 2);
          $table->timestamps();

          $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
          $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}