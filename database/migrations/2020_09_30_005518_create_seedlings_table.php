<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeedlingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seedlings', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->text("description");
            $table->unsignedBigInteger('group_id');
            $table->foreign('group_id')->references('id')->on('groups');
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
        Schema::dropIfExists('seedlings');
    }
}
