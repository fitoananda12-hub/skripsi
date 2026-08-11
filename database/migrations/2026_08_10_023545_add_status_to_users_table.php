<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Status registrasi: pending = menunggu persetujuan admin, approved = disetujui, rejected = ditolak
            $table->enum('registration_status', ['pending', 'approved', 'rejected'])
                  ->default('approved') // default approved untuk backward compatibility (user lama)
                  ->after('is_active');
            $table->text('rejection_reason')->nullable()->after('registration_status');
            $table->timestamp('approved_at')->nullable()->after('rejection_reason');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete()->after('approved_at');
        });

        // Set semua user yang sudah ada ke status 'approved' agar tidak terganggu
        DB::table('users')->update(['registration_status' => 'approved']);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn(['registration_status', 'rejection_reason', 'approved_at', 'approved_by']);
        });
    }
};
