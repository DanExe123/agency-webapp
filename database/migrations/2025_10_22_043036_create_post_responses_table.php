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
        Schema::create('post_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->foreignId('agency_id')->constrained('users')->onDelete('cascade');
            $table->text('message')->nullable();
            $table->decimal('proposed_rate', 10, 2)->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected', 'negotiating', 'closed'])->default('pending');
            $table->string('chat_id')->nullable(); // Optional link to Chatify
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_responses');
    }
};
