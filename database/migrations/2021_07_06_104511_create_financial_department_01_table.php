<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialDepartment01Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_department_01', function (Blueprint $table) {
            $table->id();
            $table->string('district_office_name',100)->nullable();
            $table->string('district_office_id',50)->nullable();
            $table->string('month',100)->nullable();
            $table->string('year',100)->nullable();
            $table->text('json',)->nullable();
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
        Schema::dropIfExists('financial_department_01');
    }
}