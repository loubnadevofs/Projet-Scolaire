<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('enseignant_matiere_classe', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idEnsei');
            $table->unsignedBigInteger('idMatiere');
            $table->unsignedBigInteger('idClasse');
            $table->timestamps();

            $table->foreign('idEnsei')->references('idEnsei')->on('enseignants')->onDelete('cascade');
            $table->foreign('idMatiere')->references('idMatiere')->on('matieres')->onDelete('cascade');
            $table->foreign('idClasse')->references('idClasse')->on('classes')->onDelete('cascade');

            // للتأكد من أن نفس الأستاذ لا يدرس نفس المادة مرتين لنفس القسم
            $table->unique(['idEnsei', 'idMatiere', 'idClasse']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enseignant_matiere_classe');
    }
};
