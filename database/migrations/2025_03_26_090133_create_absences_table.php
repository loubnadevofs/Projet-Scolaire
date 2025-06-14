<?php
// database/migrations/2023_01_01_000006_create_absences_table.php
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
        Schema::create('absences', function (Blueprint $table) {
            $table->id('idA');
            $table->unsignedBigInteger('idEtu');
            $table->date('dateAbsen');
            $table->float('nbrHeuAbsence');
            $table->timestamps();

            $table->foreign('idEtu')->references('idEtu')->on('etudiants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absences');
    }
};