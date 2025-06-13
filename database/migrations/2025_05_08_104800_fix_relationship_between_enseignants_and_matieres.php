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
        // Create pivot table
        Schema::create('enseignant_matiere', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idEnsei');
            $table->unsignedBigInteger('idMatiere');
            $table->timestamps();
            
            $table->foreign('idEnsei')->references('idEnsei')->on('enseignants')->onDelete('cascade');
            $table->foreign('idMatiere')->references('idMatiere')->on('matieres')->onDelete('cascade');
            
            // Ensure each teacher-subject pair is unique
            $table->unique(['idEnsei', 'idMatiere']);
        });
        
        // Drop the foreign key constraint from enseignants table
        Schema::table('enseignants', function (Blueprint $table) {
            $table->dropForeign(['idMatiere']);
            $table->dropColumn('idMatiere');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore the original design
        Schema::table('enseignants', function (Blueprint $table) {
            $table->unsignedBigInteger('idMatiere');
            $table->foreign('idMatiere')->references('idMatiere')->on('matieres')->onDelete('cascade');
        });
        
        // Drop the pivot table
        Schema::dropIfExists('enseignant_matiere');
    }
};