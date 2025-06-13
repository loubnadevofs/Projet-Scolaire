<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    /**
     * Afficher la page des paramètres
     */
    public function index()
    {
        // Récupérer tous les paramètres
        $generalSettings = Setting::where('category', 'general')->get()->pluck('value', 'key');
        $notificationSettings = Setting::where('category', 'notifications')->get()->pluck('value', 'key');
        $academicSettings = Setting::where('category', 'academic')->get()->pluck('value', 'key');
        
        return view('settings.index', compact('generalSettings', 'notificationSettings', 'academicSettings'));
    }

    /**
     * Enregistrer les paramètres généraux
     */
    public function saveGeneral(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'school_name' => 'required|string|max:255',
            'school_email' => 'required|email',
            'school_phone' => 'required|string|max:20',
            'school_address' => 'required|string',
            'academic_year' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Mettre à jour ou créer chaque paramètre
        foreach ($request->except('_token') as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key, 'category' => 'general'],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Paramètres généraux enregistrés avec succès');
    }

    /**
     * Enregistrer les paramètres de notation
     */
    public function saveAcademic(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'passing_grade' => 'required|numeric|min:0|max:20',
            'grading_system' => 'required|string|in:0-20,0-100,letter',
            'semester_count' => 'required|numeric|min:1|max:3',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Mettre à jour ou créer chaque paramètre
        foreach ($request->except('_token') as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key, 'category' => 'academic'],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Paramètres académiques enregistrés avec succès');
    }

    /**
     * Enregistrer les paramètres de notification
     */
    public function saveNotifications(Request $request)
    {
        $notifications = $request->has('notifications') ? $request->notifications : [];
        
        // Mettre à jour tous les paramètres de notification
        Setting::updateOrCreate(
            ['key' => 'email_notifications', 'category' => 'notifications'],
            ['value' => in_array('email', $notifications) ? '1' : '0']
        );
        
        Setting::updateOrCreate(
            ['key' => 'sms_notifications', 'category' => 'notifications'],
            ['value' => in_array('sms', $notifications) ? '1' : '0']
        );
        
        Setting::updateOrCreate(
            ['key' => 'absence_alerts', 'category' => 'notifications'],
            ['value' => in_array('absence', $notifications) ? '1' : '0']
        );
        
        Setting::updateOrCreate(
            ['key' => 'grade_alerts', 'category' => 'notifications'],
            ['value' => in_array('grade', $notifications) ? '1' : '0']
        );

        return redirect()->back()->with('success', 'Paramètres de notification enregistrés avec succès');
    }

    /**
     * Télécharger le logo de l'école
     */
    public function uploadLogo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'school_logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('school_logo')) {
            $image = $request->file('school_logo');
            $filename = 'school_logo.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/logos', $filename);
            
            Setting::updateOrCreate(
                ['key' => 'school_logo', 'category' => 'general'],
                ['value' => 'storage/logos/' . $filename]
            );
            
            return redirect()->back()->with('success', 'Logo téléchargé avec succès');
        }
        
        return redirect()->back()->with('error', 'Erreur lors du téléchargement du logo');
    }
}