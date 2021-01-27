<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->id()->unique()->autoIncrement();
            $table->string("name",100)->nullable(false);
            $table->unsignedBigInteger("parent_id")->nullable(true)->default(null);
            $table->timestamps();

            $table->foreign('parent_id')->references("id")->on("category")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category');
    }
}
