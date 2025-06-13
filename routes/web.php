<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\FormateurController;
use App\Http\Controllers\UnifiedAuthController;

// ========== AUTHENTIFICATION UNIFIÉE ==========
Route::get('/login', [UnifiedAuthController::class, 'showLoginForm'])->name('enseignant.login');
Route::post('/login', [UnifiedAuthController::class, 'login']);
Route::post('/logout', [UnifiedAuthController::class, 'logout'])->name('enseignant.logout');

// Redirection des anciennes routes
Route::get('/admin/login', function() {
    return redirect()->route('login');
});
Route::get('/enseignant/login', function() {
    return redirect()->route('login');
});

// ========== ADMIN ROUTES ==========
Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    Route::get('/', 'App\Http\Controllers\Admin\DashboardController@index')->name('dashboard');
    Route::resource('etudiants', 'App\Http\Controllers\EtudiantController');
    Route::resource('enseignants', 'App\Http\Controllers\FormateurController');
   
    Route::resource('matieres', 'App\Http\Controllers\MatiereController');
    Route::resource('classes', 'App\Http\Controllers\ClasseController');
    Route::resource('absences', 'App\Http\Controllers\AbsenceController');
    Route::resource('notations', 'App\Http\Controllers\NotationController');
    
    // Paramètres
    Route::get('/parametres', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
    Route::post('/parametres/general', [App\Http\Controllers\SettingsController::class, 'saveGeneral'])->name('settings.save.general');
    Route::post('/parametres/academic', [App\Http\Controllers\SettingsController::class, 'saveAcademic'])->name('settings.save.academic');
    Route::post('/parametres/notifications', [App\Http\Controllers\SettingsController::class, 'saveNotifications'])->name('settings.save.notifications');
    Route::post('/parametres/logo', [App\Http\Controllers\SettingsController::class, 'uploadLogo'])->name('settings.upload.logo');
});

// ========== ENSEIGNANT ROUTES ==========
Route::middleware(['auth:enseignant'])->prefix('enseignant')->name('enseignant.')->group(function () {
    Route::get('/dashboard', [EnseignantController::class, 'dashboard'])->name('dashboard');
    Route::get('/matieres', [EnseignantController::class, 'matieres'])->name('matieres');
    Route::get('/classes', [EnseignantController::class, 'classes'])->name('classes');
    Route::get('/etudiants', [EnseignantController::class, 'etudiants'])->name('etudiants');
    
    // Gestion des résultats/notes
    Route::get('/resultats', [EnseignantController::class, 'resultats'])->name('resultats');
    Route::get('/add-result/{classe_id?}', [EnseignantController::class, 'addResult'])->name('add-result');
    Route::post('/store-result', [EnseignantController::class, 'storeResult'])->name('store-result');
   
   
    Route::post('/store-quick-note', [EnseignantController::class, 'storeQuickNote'])->name('store-quick-note');
   
    // CRUD des notes
    Route::put('/resultats/{id}', [EnseignantController::class, 'updateNote'])->name('resultats.update');
    Route::delete('/resultats/{id}', [EnseignantController::class, 'deleteNote'])->name('notes.delete');
    Route::post('/delete-multiple-notes', [EnseignantController::class, 'deleteMultipleNotes'])->name('delete-multiple-notes');
Route::put('/notes.update/{id}', [EnseignantController::class, 'updateNote'])->name('notes.update');
   
    // Gestion du profil
    Route::get('/profil', [EnseignantController::class, 'profil'])->name('profil');
    Route::put('/profil', [EnseignantController::class, 'updateProfil'])->name('profil.update');
   
    // Routes pour les absences
    Route::get('/absences', [EnseignantController::class, 'absences'])->name('absences');
    Route::post('/absences/store', [EnseignantController::class, 'storeAbsence'])->name('store-absence');
    Route::put('/absences/{id}/update', [EnseignantController::class, 'updateAbsence'])->name('update-absence');
    Route::delete('/absences/{id}', [EnseignantController::class, 'deleteAbsence'])->name('delete-absence');
   Route::get('get-students-by-class-matiere', [EnseignantController::class, 'getStudentsByClassMatiere'])
    ->name('get-students-by-class-matiere');
    
    // Routes AJAX pour les absences
    Route::get('/get-etudiants/{classeId}', [EnseignantController::class, 'getEtudiantsByClasse'])->name('get-etudiants');
    Route::get('/get-matieres/{classeId}', [EnseignantController::class, 'getMatieresByClasse'])->name('get-matieres');
   
    // Rapport des absences
    Route::get('/absences/rapport', [EnseignantController::class, 'generateAbsenceReport'])->name('rapport-absences');
});

// Autres routes
Route::get('/profile/edit', 'App\Http\Controllers\ProfileController@edit')->name('profile.edit');
Route::get('locale/{locale}', 'App\Http\Controllers\LocaleController@switchLocale')->name('locale.switch');

// Page d'accueil
Route::get('/', function () {
    return view('accueil');
})->name('accueil');
