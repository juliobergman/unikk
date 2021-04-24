<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsSchemasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports_schemas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->default(1)->constrained();


            $table->unsignedBigInteger('parent')->nullable();
            $table->foreign('parent')->references('id')->on('reports_schemas');


            $table->string('name');
            $table->enum('action', ['add', 'substract'])->default('add');
            $table->softDeletes();
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
        Schema::dropIfExists('reports_schemas');
    }
}
