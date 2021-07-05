<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInitiationYearTaxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('initiation_year_tax', function (Blueprint $table) {
            $table->id();
            $table->string('district_office_name',100)->nullable();
            $table->string('district_office_id',50)->nullable();
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
        Schema::dropIfExists('initiation_year_tax');
    }
}
