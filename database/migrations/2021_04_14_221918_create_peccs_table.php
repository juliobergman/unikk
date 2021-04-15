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

            $table->string('fund');
            $table->string('type');
            $table->text('region');
            $table->string('based');
            $table->text('main_countries');
            $table->text('main_cities');
            $table->text('sector');
            $table->text('geo_focus');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('peccs');
    }
}
