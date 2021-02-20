<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->enum("type",["offer","category"]);
            $table->string("name", 100);
            $table->dateTime("end_date");
            $table->double("amount");
            $table->unsignedBigInteger("category_id")->nullable(true)->default(null);
            $table->unsignedBigInteger('offer_id')->nullable(true)->default(null);
            $table->timestamps();

            $table->foreign('offer_id')->references("id")->on("offer")->onDelete("cascade");
            $table->foreign('category_id')->references("id")->on("category")->onDelete("cascade");


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount');
    }
}
