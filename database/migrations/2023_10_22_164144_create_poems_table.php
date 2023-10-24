<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poems', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->unique();
            $table->text('body');
            $table->foreignId('genre_id')->constrained('genres')->cascadeOnUpdate()->cascadeOnDelete()->comment('the poem genre type');
            $table->foreignId('author_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete()->comment('the user who created the poem');
            $table->tinyInteger('status')->default(1)->comment('0=unpublished, 1=published');
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
        Schema::dropIfExists('poems');
    }
}
