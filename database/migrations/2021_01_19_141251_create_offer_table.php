<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string("name", 100);
            $table->double("price", 8, 2)->nullable(false)->default(0);
            $table->text('description');
            $table->integer("stock")->nullable(false)->default(0);
            $table->unsignedBigInteger("creator_id")->nullable(false);
            $table->unsignedBigInteger("category_id")->nullable(false);
            $table->string('offerable_type')->nullable(false);
            $table->unsignedBigInteger("offerable_id")->nullable(false);
            //$table->enum("status", ["Inactive", "SoldOut", "Active", "ComingSoon"])->default("Inactive");
//            $table->dateTime("out_of_stock_date")->default(null)->nullable(true);
//            $table->dateTime("restock_date")->default(null)->nullable(true);
//            $table->dateTime("activation_date")->default(null)->nullable(true);
            $table->timestamps();

            $table->foreign('category_id')->references("id")->on("category")->onDelete("cascade");;
            $table->foreign('creator_id')->references("id")->on("users")->onDelete("cascade");;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offer');
    }
}
