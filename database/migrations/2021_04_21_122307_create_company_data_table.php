<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyDataTable extends Migration
{

    public function up()
    {
        Schema::create('company_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');

            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('sector')->nullable();
            $table->string('country')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->text('info')->nullable();
            $table->string('logo')->nullable();
            // Settings



            // Target Data
            $table->text('company_ov')->nullable();
            $table->text('financial_ov')->nullable();
            $table->text('milestones')->nullable();
            $table->text('competitors')->nullable();
            $table->text('goals')->nullable();
            $table->text('channels')->nullable();
            $table->text('challenges')->nullable();

            // Soft & TimeStamps
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('company_data');
    }
}
