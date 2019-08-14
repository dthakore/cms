<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatabaseTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('case_number', 255)->nullable(false);
            $table->string('complainant_name', 255)->nullable(false);
            $table->text('complainant_details')->nullable();
            $table->date('date_of_filing')->nullable(false);
            $table->string('court')->nullable();
            $table->string('stage')->nullable(false);
            $table->date('next_date')->nullable();
            $table->string('comments',255)->nullable();
            $table->timestamps();
        });


        Schema::create('case_entries', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->date('date')->nullable(false);
            $table->string('coram', 255)->nullable();
            $table->string('stage', 255)->nullable(false);
            $table->date('next_date')->nullable();
            $table->string('comments',255)->nullable();
            $table->string('attachment', 255)->nullable();
            $table->unsignedInteger('case_id');
            $table->timestamps();
            $table->foreign('case_id')->references('id')->on('cases')->onDelete('cascade');
        });

        Schema::create('case_attachments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('attachment', 255)->nullable();
            $table->string('comments',255)->nullable();
            $table->unsignedInteger('case_id');
            $table->timestamps();
            $table->foreign('case_id')->references('id')->on('cases')->onDelete('cascade');
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
            $table->dropForeign(['case_id']);
        });

        Schema::table('case_attachments', function (Blueprint $table) {
            $table->dropForeign(['case_id']);
        });

        Schema::dropIfExists('cases');
        Schema::dropIfExists('case_entries');
        Schema::dropIfExists('case_attachments');
    }
}
