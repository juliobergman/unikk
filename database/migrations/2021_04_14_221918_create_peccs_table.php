<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeccsTable extends Migration
{

    public function up()
    {
        Schema::create('peccs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->default(1)->constrained();

            $table->string('fund')->nullable();
            $table->string('type')->nullable();
            $table->text('region')->nullable();
            $table->string('based')->nullable();
            $table->text('main_countries')->nullable();
            $table->text('main_cities')->nullable();
            $table->text('sector')->nullable();
            $table->text('geo_focus')->nullable();
            $table->text('logo')->nullable();
            $table->text('notes')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('peccs');
    }
}
