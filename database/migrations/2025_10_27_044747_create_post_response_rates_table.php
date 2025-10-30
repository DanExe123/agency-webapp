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
        Schema::create('post_response_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_response_id')->constrained()->onDelete('cascade');
            $table->foreignId('guard_type_id')->constrained('security_guard_types')->onDelete('cascade');
            $table->decimal('proposed_rate', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_response_rates');
    }
};
