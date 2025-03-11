<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('account', function (Blueprint $table) {
            $table->uuid('account_uuid')->primary();
            $table->string('name', 100);
            $table->uuid('account_type_uuid');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('account_type_uuid')
                  ->references('account_type_uuid')
                  ->on('account_type')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('account');
    }
};
