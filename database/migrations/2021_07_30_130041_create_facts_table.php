<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facts', function (Blueprint $table) {
            $table->id();
            $table->date('date')->foreign('date')->references('date')->on('date_dimensions');
            $table->foreignId('code_id')->foreign('code_id')->references('id')->on('codes');
            $table->foreignId('report_id')->foreign('report_id')->references('id')->on('reports');
            $table->foreignId('company_id')->constrained();
            $table->foreignId('user_id')->constrained();

            $table->decimal('amount', 20,2,false);

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
        Schema::dropIfExists('facts');
    }
}
