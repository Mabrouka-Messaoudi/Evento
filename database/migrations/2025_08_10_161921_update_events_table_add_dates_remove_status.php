<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
    $table->dateTime('date_debut')->nullable()->after('description');
    $table->dateTime('date_fin')->nullable()->after('date_debut');
});
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Ajouter à nouveau statut

            // Supprimer date_debut et date_fin
            $table->dropColumn(['date_debut', 'date_fin']);
        });
    }
};
