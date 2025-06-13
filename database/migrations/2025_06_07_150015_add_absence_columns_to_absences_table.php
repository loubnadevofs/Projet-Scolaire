<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('absences', function (Blueprint $table) {
            $table->enum('type_absence', ['absence', 'retard'])->default('absence');
            $table->boolean('justifiee')->default(false);
            $table->text('motif')->nullable();
            $table->unsignedBigInteger('idMatiere')->nullable();
            
            $table->foreign('idMatiere')
                  ->references('idMatiere')
                  ->on('matieres')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('absences', function (Blueprint $table) {
            $table->dropForeign(['idMatiere']);
            $table->dropColumn(['type_absence', 'justifiee', 'motif', 'idMatiere']);
        });
    }
};