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
    Schema::create('enseignant_matiere_classe', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('idEnsei');   // clé étrangère vers enseignants
        $table->unsignedBigInteger('idMatiere'); // clé étrangère vers matieres
        $table->unsignedBigInteger('idClasse');  // clé étrangère vers classes
        $table->timestamps();

        $table->foreign('idEnsei')->references('id')->on('enseignants')->onDelete('cascade');
        $table->foreign('idMatiere')->references('id')->on('matieres')->onDelete('cascade');
        $table->foreign('idClasse')->references('id')->on('classes')->onDelete('cascade');

        // Optionnel : index unique pour éviter les doublons
        $table->unique(['idEnsei', 'idMatiere', 'idClasse']);
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enseignant_matiere_classe');
    }
};
