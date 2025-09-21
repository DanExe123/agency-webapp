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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('logo')->nullable();
            $table->boolean('featured')->default(false);
            $table->string('website')->nullable();
            $table->string('phone');
            $table->string('email');
            $table->text('description');
            $table->text('requirements')->nullable();
            $table->string('location');
            $table->string('needs');
            $table->date('founded_in')->nullable();
            $table->string('company_size')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
