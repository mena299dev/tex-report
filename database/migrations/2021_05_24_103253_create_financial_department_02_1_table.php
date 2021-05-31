<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialDepartment021Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_department_02_1', function (Blueprint $table) {
            $table->id();
            $table->string('sequence',10)->nullable();
            $table->string('district_office_name',100)->nullable();
            $table->integer('district_office_id')->nullable();
            $table->string('month',100)->nullable();
            $table->string('year',100)->nullable();
            $table->string('district',100)->nullable();
            $table->string('defaulter_name',250)->nullable();
            $table->integer('defaulter_year')->nullable();
            $table->float('tax_amount',20,2)->nullable();
            $table->float('increment_amount',20,2)->nullable();
            $table->date('date_of_notice')->nullable();
            $table->date('date_of_payment')->nullable();
            $table->text('remark')->nullable();
            $table->timestamps();

            $table->index('district_office_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('financial_department_02_1');
    }
}
