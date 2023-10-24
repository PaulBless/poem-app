<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('headline')->nullable()->comment('what the user does, eg. job title');
            $table->string('about_me')->nullable()->comment('short bio of the user');
            $table->string('address')->nullable();
            $table->string('phone_number')->unique()->nullable();
            $table->string('login_otp')->length(6)->comment('OTP for 2factor authentication');
            $table->string('profile_pic')->default("default.jpg");
            $table->boolean('status')->default(true)->comment('1=active, 0=inactive');
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
