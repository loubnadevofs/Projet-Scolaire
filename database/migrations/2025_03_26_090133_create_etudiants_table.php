<?php
// database/migrations/2023_01_01_000002_create_etudiants_table.php
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
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id('idEtu');
            $table->string('nom', 50);
            $table->string('prenom', 50);
            $table->unsignedBigInteger('idClasse');
            $table->date('dateNaissance');
            $table->timestamps();

            $table->foreign('idClasse')->references('idClasse')->on('classes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etudiants');
    }
};