<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialSchemaDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_schema_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('financial_schema_id')->constrained();
            $table->unsignedBigInteger('parent')->nullable();
            $table->foreign('parent')->references('id')->on('financial_schema_data');
            $table->integer('code')->unique()->nullable();
            $table->string('name');
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
        Schema::dropIfExists('financial_schema_data');
    }
}
