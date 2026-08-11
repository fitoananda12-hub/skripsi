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
        Schema::table('complaints', function (Blueprint $table) {
            $table->enum('status', ['submitted', 'in_progress', 'returned', 'resolved', 'closed'])
                  ->default('submitted')
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->enum('status', ['submitted', 'in_progress', 'resolved', 'closed'])
                  ->default('submitted')
                  ->change();
        });
    }
};
