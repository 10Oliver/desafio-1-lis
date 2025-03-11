<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('account_type', function (Blueprint $table) {
            // $table->engine = 'InnoDB';
            $table->uuid('account_type_uuid')->primary();
            $table->string('name', 100);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('account_type');
    }
};
