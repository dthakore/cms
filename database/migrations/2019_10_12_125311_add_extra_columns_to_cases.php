<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraColumnsToCases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cases', function (Blueprint $table) {
            $table->text('role2')->after('case_number');
            $table->text('user2')->after('case_number');
            $table->text('role1')->after('case_number');
            $table->text('user1')->after('case_number');
            $table->integer('type')->unsigned()->after('case_number');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cases', function (Blueprint $table) {
            //
        });
    }
}
