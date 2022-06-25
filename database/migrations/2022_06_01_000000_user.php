<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class User extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->autoIncrement();
            $table->string('user_name');
            $table->string('user_password')->nullable();
            $table->string('user_email')->nullable();
            $table->string('user_phone')->nullable();
            $table->text('user_address')->nullable();
            $table->unsignedTinyInteger('user_admin')->default(0);
            $table->string('user_remember_token', 100)->nullable();
            $table->dateTime('user_created_at')->useCurrent();
            $table->dateTime('user_updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
