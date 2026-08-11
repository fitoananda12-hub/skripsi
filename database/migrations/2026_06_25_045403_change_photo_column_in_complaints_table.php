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
            $table->text('photo')->nullable()->change();
        });

        // Convert existing non-JSON values to JSON array
        $complaints = Illuminate\Support\Facades\DB::table('complaints')->select('id', 'photo')->get();
        foreach ($complaints as $complaint) {
            if ($complaint->photo) {
                $photo = $complaint->photo;
                $trimmed = trim($photo);
                if (!(str_starts_with($trimmed, '[') && str_ends_with($trimmed, ']'))) {
                    Illuminate\Support\Facades\DB::table('complaints')
                        ->where('id', $complaint->id)
                        ->update(['photo' => json_encode([$photo])]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->string('photo', 255)->nullable()->change();
        });
    }
};
