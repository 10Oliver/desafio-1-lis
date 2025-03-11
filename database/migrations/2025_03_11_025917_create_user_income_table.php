<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_income', function (Blueprint $table) {
            $table->uuid('user_income_uuid')->primary();
            $table->uuid('user_uuid');
            $table->uuid('income_uuid');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_uuid')
                  ->references('user_uuid')
                  ->on('user')
                  ->onDelete('cascade');

            $table->foreign('income_uuid')
                  ->references('income_uuid')
                  ->on('income')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_income');
    }
};
