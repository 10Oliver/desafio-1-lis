<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('expense', function (Blueprint $table) {
            $table->uuid('expense_uuid')->primary();
            $table->string('name', 100);
            $table->uuid('expense_type_uuid');
            $table->string('ticket_path', 255)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('expense_type_uuid')
                  ->references('expense_type_uuid')
                  ->on('expense_type')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('expense');
    }
};
