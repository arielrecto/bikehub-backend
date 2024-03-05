<?php

use App\Models\Ride;
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
        Schema::create('ride_buddies', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Ride::class)->constrained()->onDelete('CASCADE');
            $table->foreignIdFor(User::class, 'participant_id')->constrained()->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ride_buddies');
    }
};
