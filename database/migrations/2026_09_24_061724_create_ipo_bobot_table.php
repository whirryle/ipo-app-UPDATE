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
        Schema::create('ipo_bobot', function (Blueprint $table) {
            $table->id();
            $table->year('year')->unique();
            $table->decimal('literasi_fisik', 5, 2)->default(7);
            $table->decimal('partisipasi', 5, 2)->default(7);
            $table->decimal('perkembangan_personal', 5, 2)->default(6);
            $table->decimal('kesehatan', 5, 2)->default(6);
            $table->decimal('ekonomi', 5, 2)->default(4);
            $table->decimal('kebugaran', 5, 2)->default(3);
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ipo_bobot');
    }
};
