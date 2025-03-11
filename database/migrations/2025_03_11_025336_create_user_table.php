<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->uuid('user_uuid')->primary();
            $table->string('first_name', 50);
            $table->string('second_name', 50)->nullable();
            $table->string('lastname', 50);
            $table->string('second_lastname', 50)->nullable();
            $table->string('dui',10)->nullable();
            $table->string('document')->nullable();
            $table->string('email', 100)->unique();
            $table->string('phone', 20);
            $table->json('country_data')->nullable();

            $table->string('password', 255);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user');
    }
};
