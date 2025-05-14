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
        Schema::table('dossier_medical', function (Blueprint $table) {
            $table->text('activite_professionnelles_anterieures')->nullable();
            $table->text('antecedents_familiaux')->nullable();
            $table->text('antecedents_personnels')->nullable();
            $table->text('maladies_professionnelles')->nullable();
            $table->text('observations')->nullable();

            $table->dropColumn('description'); // Suppression de l'ancien champ
        });
    }

    public function down(): void
    {
        Schema::table('dossier_medicals', function (Blueprint $table) {
            $table->text('description')->nullable();

            $table->dropColumn([
                'activite_professionnelles_anterieures',
                'antecedents_familiaux',
                'antecedents_personnels',
                'maladies_professionnelles',
                'observations',
            ]);
        });
    }
};
