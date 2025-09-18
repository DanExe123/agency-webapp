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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('about_us')->nullable();
            $table->string('logo_path')->nullable();
            $table->string('certificate_path')->nullable();
            $table->string('valid_id_path')->nullable();
            $table->string('organization_type')->nullable();
            $table->string('industry_type')->nullable();
            $table->string('team_size')->nullable();
            $table->date('year_established')->nullable();
            $table->string('website')->nullable();
            $table->text('vision')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
