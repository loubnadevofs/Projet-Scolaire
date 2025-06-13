<?php
// database/migrations/2023_01_01_000005_create_notations_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * تنفيذ الهجرة.
     */
    public function up(): void
    {
        Schema::create('notations', function (Blueprint $table) {
            // عمود الهوية الفريد (id) - المفتاح الأساسي الوحيد
            $table->id();
            
            // أعمدة المفاتيح الأجنبية
            $table->unsignedBigInteger('idEtu');
            $table->unsignedBigInteger('idMatiere');
            $table->unsignedBigInteger('idClasse'); // إضافة الحقل المفقود
            
            // بيانات التقييم
            $table->decimal('note', 5, 2); // استخدام decimal بدلاً من float للدقة
            $table->string('type_evaluation')->nullable(); // إضافة نوع التقييم
            $table->date('dateEv');
            $table->string('annee_scolaire');
            
            // الطوابع الزمنية
            $table->timestamps();
            
            // إضافة مؤشرات للأداء
            $table->index(['idEtu', 'idMatiere', 'dateEv']);
            $table->index('annee_scolaire');
            
            // تحديد العلاقات بالمفاتيح الأجنبية
            $table->foreign('idEtu')
                  ->references('idEtu')
                  ->on('etudiants')
                  ->onDelete('cascade');
                  
            $table->foreign('idMatiere')
                  ->references('idMatiere')
                  ->on('matieres')
                  ->onDelete('cascade');
                  
            $table->foreign('idClasse')
                  ->references('idClasse')
                  ->on('classes')
                  ->onDelete('cascade');
                  
            // إضافة قيد فريد لمنع تكرار التقييم لنفس الطالب والمادة في نفس التاريخ
            $table->unique(['idEtu', 'idMatiere', 'dateEv', 'type_evaluation'], 'unique_notation');
        });
    }

    /**
     * التراجع عن الهجرة.
     */
    public function down(): void
    {
        Schema::dropIfExists('notations');
    }
};