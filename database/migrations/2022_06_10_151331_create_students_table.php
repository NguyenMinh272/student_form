<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('full_name',50);
            $table->string('email',50)->nullable();
            $table->string('password',255)->nullable();
            $table->string('address',50)->nullable();
            $table->string('social_id',50)->nullable();
            $table->dateTime('birthday')->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->char('phone',15)->nullable();
            $table->string('image',255)->nullable();
            $table->unsignedBigInteger('faculty_id')->unsigned()->nullable();
            $table->foreign('faculty_id')->references('id')->on('faculties');
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
        Schema::dropIfExists('students');
    }
};
