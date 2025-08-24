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
    Schema::create('favoris', function (Blueprint $table) {
        $table->id();

        // Relation avec l'utilisateur
        $table->foreignId('user_id')
              ->constrained('users')
              ->onDelete('cascade');

        // Relation avec l'événement
        $table->foreignId('event_id')
              ->constrained('events')
              ->onDelete('cascade');

        $table->timestamps();

        // Empêcher qu’un user ajoute 2 fois le même event
        $table->unique(['user_id', 'event_id']);
    });
}

public function down(): void
{
    Schema::dropIfExists('favoris');
}

};
