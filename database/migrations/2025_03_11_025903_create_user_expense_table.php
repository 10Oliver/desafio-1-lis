<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_expense', function (Blueprint $table) {
            $table->uuid('user_expense_uuid')->primary();
            $table->uuid('user_uuid');
            $table->uuid('expense_uuid');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_uuid')
                  ->references('user_uuid')
                  ->on('user')
                  ->onDelete('cascade');

            $table->foreign('expense_uuid')
                  ->references('expense_uuid')
                  ->on('expense')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_expense');
    }
};

