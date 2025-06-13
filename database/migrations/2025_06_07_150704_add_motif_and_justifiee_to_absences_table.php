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
    Schema::table('absences', function (Blueprint $table) {
        // Ajoutez d'abord la colonne motif si elle n'existe pas
        if (!Schema::hasColumn('absences', 'motif')) {
            $table->string('motif')->after('type_absence');
        }
    });
}

public function down()
{
    Schema::table('absences', function (Blueprint $table) {
        $table->dropColumn(['motif', 'justifiee']);
    });
}
};
