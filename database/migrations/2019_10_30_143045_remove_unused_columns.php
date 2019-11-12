<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUnusedColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cases', function(Blueprint $table) {
            $table->dropColumn('user2');
            $table->dropColumn('user1');
        });
    }

    public function down()
    {
        Schema::table('cases', function(Blueprint $table) {
//            $table->integer('next_date');
        });
    }
}
