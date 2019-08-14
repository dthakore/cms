<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique()->nullable(false);
            $table->string('alternate_email')->nullable();
            $table->string('contact_number')->nullable(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('company')->nullable();
            $table->string('password');
            $table->boolean('is_enabled')->nullable();
            $table->boolean('email_enabled')->nullable();
            $table->boolean('whatsapp_enabled')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
