<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string("name",100);
            $table->double("price",8,2)->nullable(false)->default(0);
            $table->text('description');
            $table->integer("stock")->nullable(false)->default(0);
            $table->integer("creator_id")->nullable(false);
            $table->integer("category_id")->nullable(false);
            $table->enum("status",["Inactive","SoldOut","Active","ComingSoon"])->default("Inactive");
            $table->dateTime("deactivation_date")->useCurrent()->nullable(true);
            $table->dateTime("out_of_stock_date")->default(null)->nullable(true);
            $table->dateTime("restock_date")->default(null)->nullable(true);
            $table->dateTime("activation_date")->default(null)->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
