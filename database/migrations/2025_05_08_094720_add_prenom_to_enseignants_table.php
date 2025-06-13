<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrenomToEnseignantsTable extends Migration
{
    public function up()
    {
        Schema::table('enseignants', function (Blueprint $table) {
            $table->string('prenom')->nullable(); // Ajoute la colonne prenom
        });
    }

    public function down()
    {
        Schema::table('enseignants', function (Blueprint $table) {
            $table->dropColumn('prenom'); // Supprime la colonne si la migration est annulée
        });
    }
}
