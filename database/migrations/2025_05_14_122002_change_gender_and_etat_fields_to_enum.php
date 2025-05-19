<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('employe', function (Blueprint $table) {
            $table->dropColumn('gender');
            $table->dropColumn('etat');
        });

        Schema::table('employe', function (Blueprint $table) {
            $table->enum('gender', ['Homme', 'Femme'])->nullable();
            $table->enum('etat', ['Actif', 'Inactif'])->nullable();
        });

        Schema::table('medecin', function (Blueprint $table) {
            $table->dropColumn('gender');
        });

        Schema::table('medecin', function (Blueprint $table) {
            $table->enum('gender', ['Homme', 'Femme'])->nullable();
        });
    }

    public function down()
    {
        Schema::table('employe', function (Blueprint $table) {
            $table->dropColumn(['gender', 'etat']);
            $table->boolean('gender')->nullable();
            $table->boolean('etat')->nullable();
        });

        Schema::table('medecin', function (Blueprint $table) {
            $table->dropColumn('gender');
            $table->boolean('gender')->nullable();
        });
    }
};
