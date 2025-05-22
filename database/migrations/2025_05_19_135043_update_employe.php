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
        Schema::table('employe', function (Blueprint $table) {
            // Supprimer l'email de la table employe
            $table->dropColumn('email');

            // Ajouter la relation vers users
            Schema::table('employe', function (Blueprint $table) {
            // Recréer correctement avec contrainte de clé étrangère
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users') // ou juste ->constrained() si table users
                  ->onDelete('cascade');
                });
        });
    }
};
