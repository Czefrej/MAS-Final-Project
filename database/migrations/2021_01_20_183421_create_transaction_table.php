<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->dateTime('transaction_datetime')->nullable(true);
            $table->unsignedBigInteger('offer_id')->nullable(true);
            $table->unsignedBigInteger('user_id')->nullable(true);
            $table->integer('quantity');
            $table->double('price');
            $table->timestamps();

            $table->foreign('offer_id')->references("id")->on("offer")->onDelete("cascade");
            $table->foreign('user_id')->references("id")->on("users")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction');
    }
}
