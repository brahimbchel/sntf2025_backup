<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultValueToModelTypeInModelHasRolesTable extends Migration
{
    public function up()
    {
        Schema::table('model_has_roles', function (Blueprint $table) {
            // Vérifier si la colonne model_type existe, puis la modifier
            if (Schema::hasColumn('model_has_roles', 'model_type')) {
                $table->string('model_type')->default('App\\Models\\User')->change(); // Valeur par défaut
            }
        });
    }

    public function down()
    {
        Schema::table('model_has_roles', function (Blueprint $table) {
            // Revert the default value to null
            $table->string('model_type')->nullable()->change(); // Rétablir à null si besoin
        });
    }
}
