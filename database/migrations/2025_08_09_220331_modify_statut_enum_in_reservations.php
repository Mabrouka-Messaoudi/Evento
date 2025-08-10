<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->enum('statut', ['en_attente', 'accepté', 'refusé', 'annulé'])
                  ->default('en_attente')
                  ->change();
        });
    }

    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->enum('statut', ['en_attente', 'accepté', 'refusé'])
                  ->default('en_attente')
                  ->change();
        });
    }
};
