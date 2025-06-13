<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Paramètres généraux
        Setting::updateOrCreate(['key' => 'school_name', 'category' => 'general'], ['value' => 'École Polytechnique']);
        Setting::updateOrCreate(['key' => 'school_email', 'category' => 'general'], ['value' => 'contact@ecole.com']);
        Setting::updateOrCreate(['key' => 'school_phone', 'category' => 'general'], ['value' => '01 23 45 67 89']);
        Setting::updateOrCreate(['key' => 'school_address', 'category' => 'general'], ['value' => '123 Rue Principale, Ville']);
        Setting::updateOrCreate(['key' => 'academic_year', 'category' => 'general'], ['value' => '2024-2025']);
        
        // Paramètres académiques
        Setting::updateOrCreate(['key' => 'passing_grade', 'category' => 'academic'], ['value' => '10']);
        Setting::updateOrCreate(['key' => 'grading_system', 'category' => 'academic'], ['value' => '0-20']);
        Setting::updateOrCreate(['key' => 'semester_count', 'category' => 'academic'], ['value' => '2']);
        
        // Paramètres de notification
        Setting::updateOrCreate(['key' => 'email_notifications', 'category' => 'notifications'], ['value' => '1']);
        Setting::updateOrCreate(['key' => 'sms_notifications', 'category' => 'notifications'], ['value' => '0']);
        Setting::updateOrCreate(['key' => 'absence_alerts', 'category' => 'notifications'], ['value' => '1']);
        Setting::updateOrCreate(['key' => 'grade_alerts', 'category' => 'notifications'], ['value' => '1']);
    }
}