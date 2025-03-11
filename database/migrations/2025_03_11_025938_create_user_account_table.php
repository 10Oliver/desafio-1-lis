<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_account', function (Blueprint $table) {
            $table->uuid('user_account_uuid')->primary();
            $table->uuid('user_uuid');
            $table->uuid('account_uuid');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_uuid')
                  ->references('user_uuid')
                  ->on('user')
                  ->onDelete('cascade');

            $table->foreign('account_uuid')
                  ->references('account_uuid')
                  ->on('account')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_account');
    }
};
