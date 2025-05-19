<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('consultation', function (Blueprint $table) {
            $table->enum('type', [
                'Admission',
                'Périodique',
                'Spontané',
                'Reprise',
                'Contrôle',
                'AccidentDeTravail',
                'ContreVisite',
                'Réintégration',
            ])->nullable();

            $table->enum('aptitude', [
                'apte',
                'apte avec reserve',
                'inapte',
                'inapte définitif'
            ])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultation', function (Blueprint $table) {
            //
        });
    }
};
