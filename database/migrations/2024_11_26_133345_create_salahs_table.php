<?php

use App\Models\Salah;
use App\Models\User;
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
        Schema::create('salahs', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('added_by', 10)->default('admin');
            $table->timestamps();
        });

        Schema::create('salah_user', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete('cascade');
            $table->foreignIdFor(Salah::class)->constrained()->cascadeOnDelete('cascade');
            $table->time('azan_time')->nullable();
            $table->time('jamath_time')->nullable();
            $table->time('last_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salahs');
        Schema::dropIfExists('salah_user');
    }
};
