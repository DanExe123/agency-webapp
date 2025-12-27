<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('user_profiles', function (Blueprint $table) {
        if (!Schema::hasColumn('user_profiles', 'is_read')) {
            $table->boolean('is_read')->default(false);
        }
    });
}


public function down()
{
    Schema::table('user_profiles', function (Blueprint $table) {
        $table->dropColumn('is_read');
    });
}

};
