<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToCaseentry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('case_entries', function (Blueprint $table) {
            $table->text('bench')->nullable()->after('coram');
            $table->text('item_number')->nullable()->after('coram');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('case_entries', function (Blueprint $table) {
            $table->dropColumn('bench');
            $table->dropColumn('item_number');
        });
    }
}
