<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnDateString extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('financial_department_02_1', 'date_of_notice_str')) {
            Schema::table('financial_department_02_1', function (Blueprint $table) {
                $table->string('date_of_notice_str', 50)->after('date_of_notice')->nullable();
            });
        }

        if (!Schema::hasColumn('financial_department_02_1', 'date_of_payment_str')) {
            Schema::table('financial_department_02_1', function (Blueprint $table) {
                $table->string('date_of_payment_str', 50)->after('date_of_payment')->nullable();
            });
        }

        if (!Schema::hasColumn('financial_department_02_2', 'date_of_notice_str')) {
            Schema::table('financial_department_02_2', function (Blueprint $table) {
                $table->string('date_of_notice_str', 50)->after('date_of_notice')->nullable();
            });
        }

        if (!Schema::hasColumn('financial_department_02_2', 'date_of_payment_str')) {
            Schema::table('financial_department_02_2', function (Blueprint $table) {
                $table->string('date_of_payment_str', 50)->after('date_of_payment')->nullable();
            });
        }


        if (!Schema::hasColumn('financial_department_02_3', 'date_of_notice_str')) {
            Schema::table('financial_department_02_3', function (Blueprint $table) {
                $table->string('date_of_notice_str', 50)->after('date_of_notice')->nullable();
            });
        }

        if (!Schema::hasColumn('financial_department_02_3', 'date_of_payment_str')) {
            Schema::table('financial_department_02_3', function (Blueprint $table) {
                $table->string('date_of_payment_str', 50)->after('date_of_payment')->nullable();
            });
        }

        if (!Schema::hasColumn('financial_department_02_4', 'date_of_payment_str')) {
            Schema::table('financial_department_02_4', function (Blueprint $table) {
                $table->string('date_of_payment_str', 50)->after('date_of_payment')->nullable();
            });
        }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('financial_department_02_1', 'date_of_notice_str')) {
            Schema::table('financial_department_02_1', function (Blueprint $table) {
                $table->dropColumn('date_of_notice_str');
            });
        }

        if (Schema::hasColumn('financial_department_02_1', 'date_of_payment_str')) {
            Schema::table('financial_department_02_3', function (Blueprint $table) {
                $table->dropColumn('date_of_payment_str');
            });
        }

        if (Schema::hasColumn('financial_department_02_2', 'date_of_notice_str')) {
            Schema::table('financial_department_02_2', function (Blueprint $table) {
                $table->dropColumn('date_of_notice_str');
            });
        }

        if (Schema::hasColumn('financial_department_02_2', 'date_of_payment_str')) {
            Schema::table('financial_department_02_2', function (Blueprint $table) {
                $table->dropColumn('date_of_payment_str');
            });
        }

        if (Schema::hasColumn('financial_department_02_3', 'date_of_notice_str')) {
            Schema::table('financial_department_02_3', function (Blueprint $table) {
                $table->dropColumn('date_of_notice_str');
            });
        }

        if (Schema::hasColumn('financial_department_02_3', 'date_of_payment_str')) {
            Schema::table('financial_department_02_3', function (Blueprint $table) {
                $table->dropColumn('date_of_payment_str');
            });
        }

        if (Schema::hasColumn('financial_department_02_4', 'date_of_payment_str')) {
            Schema::table('financial_department_02_4', function (Blueprint $table) {
                $table->dropColumn('date_of_payment_str');
            });
        }
    }
}
