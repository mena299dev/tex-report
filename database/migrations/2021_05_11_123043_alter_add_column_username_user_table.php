<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddColumnUsernameUserTable extends Migration
{
    public $set_table = 'users';
    public $set_column = 'username';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn($this->set_table, 'email')) {
            Schema::table($this->set_table, function (Blueprint $table) {
                $table->dropColumn('email');
            });
        }
        if (!Schema::hasColumn($this->set_table, $this->set_column)) {
            Schema::table($this->set_table, function (Blueprint $table) {
                $table->string($this->set_column,'50')->unique()->after('id')->index();
                $table->string('district_code','10')->after('name')->nullable();
                $table->string('email','250')->after('district_code')->default('default@tex-report.com')->nullable();
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
        if (Schema::hasColumn($this->set_table, $this->set_column)) {
            Schema::table($this->set_table, function (Blueprint $table) {
                $table->dropColumn($this->set_column);
            });
        }

        if (Schema::hasColumn($this->set_table, 'district_code')) {
            Schema::table($this->set_table, function (Blueprint $table) {
                $table->dropColumn('district_code');
            });
        }
    }
}
