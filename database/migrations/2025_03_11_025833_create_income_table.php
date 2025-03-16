<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('income', function (Blueprint $table) {
            $table->uuid('income_uuid')->primary();
            $table->string('name', 100);
            $table->uuid('income_type_uuid');
            $table->decimal('amount', 10, 2);
            @$table->date('date');
            $table->string('ticket_path', 255)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('income_type_uuid')
                ->references('income_type_uuid')
                ->on('income_type')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('income');
    }
};
