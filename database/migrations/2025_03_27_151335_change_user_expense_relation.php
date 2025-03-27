<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_expense', function (Blueprint $table) {
            $table->uuid('user_account_uuid')->after('user_expense_uuid');
            $table->foreign('user_account_uuid')
                ->references('user_account_uuid')
                ->on('user_account')
                ->onDelete('cascade');

            $table->dropForeign(['user_uuid']);
            $table->dropColumn('user_uuid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_expense', function (Blueprint $table) {
            $table->dropForeign(['user_account_uuid']);
            $table->dropColumn('user_account_uuid');

            $table->uuid('user_uuid')->after('user_expense_uuid');
            $table->foreign('user_uuid')->references('uuid')->on('user');
        });
    }
};
