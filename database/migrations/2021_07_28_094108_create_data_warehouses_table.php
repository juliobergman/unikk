<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_warehouse', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('row');
            // Keys
            $table->foreignId('company_id')->foreign('company_id')->references('id')->on('companies');
            $table->foreignId('report_id')->foreign('report_id')->references('id')->on('reports');
            $table->foreignId('category_id')->nullable()->foreign('category_id')->references('id')->on('code_categories');
            $table->unsignedBigInteger('year');
            $table->string('lvl')->index();
            // Unique
            $table->unique(['year','report_id','lvl','row'], 'unicus');

            $table->string('name')->nullable();

            $table->string('branch')->nullable();
            $table->string('row_class');
            $table->decimal('jan', 20,2,false)->nullable();
            $table->decimal('feb', 20,2,false)->nullable();
            $table->decimal('mar', 20,2,false)->nullable();
            $table->decimal('qr1', 20,2,false)->nullable();
            $table->decimal('apr', 20,2,false)->nullable();
            $table->decimal('may', 20,2,false)->nullable();
            $table->decimal('jun', 20,2,false)->nullable();
            $table->decimal('qr2', 20,2,false)->nullable();
            $table->decimal('jul', 20,2,false)->nullable();
            $table->decimal('aug', 20,2,false)->nullable();
            $table->decimal('sep', 20,2,false)->nullable();
            $table->decimal('qr3', 20,2,false)->nullable();
            $table->decimal('oct', 20,2,false)->nullable();
            $table->decimal('nov', 20,2,false)->nullable();
            $table->decimal('dec', 20,2,false)->nullable();
            $table->decimal('qr4', 20,2,false)->nullable();
            $table->decimal('yar', 20,2,false)->nullable();
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
        Schema::dropIfExists('data_warehouse');
    }
}
