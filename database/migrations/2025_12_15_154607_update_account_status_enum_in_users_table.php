<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add 'approved' to the ENUM values
            $table->enum('account_status', ['pending', 'verified', 'archived', 'rejected', 'approved'])
                  ->default('pending')
                  ->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Rollback to previous ENUM without 'approved'
            $table->enum('account_status', ['pending', 'verified', 'archived', 'rejected'])
                  ->default('pending')
                  ->change();
        });
    }
};
