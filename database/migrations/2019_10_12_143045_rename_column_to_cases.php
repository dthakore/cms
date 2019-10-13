<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnToCases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cases', function (Blueprint $table) {
            $table->renameColumn('complainant_name', 'opponent_name');
            $table->renameColumn('role1', 'client_role');
            $table->renameColumn('role2', 'opponent_role');
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
            $table->renameColumn('opponent_name', 'complainant_name');
            $table->renameColumn('client_role', 'role1');
            $table->renameColumn('opponent_role', 'role2');
        });
    }
}
