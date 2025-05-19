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
        Schema::table('employe', function (Blueprint $table) {
            $table->enum('groupe_sanguin', ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'])->nullable();
            $table->enum('situation_familiale', ['célibataire', 'marié(e)', 'divorcé(e)', 'veuf(ve)'])->nullable();
            $table->enum('service_national', ['accompli', 'dispensé', 'inapte'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employe', function (Blueprint $table) {
            //
        });
    }
};
