@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Menu des paramètres</div>
                <div class="card-body">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="general-tab" data-toggle="pill" href="#general" role="tab" aria-controls="general" aria-selected="true">
                            <i class="fas fa-school"></i> Paramètres généraux
                        </a>
                        <a class="nav-link" id="academic-tab" data-toggle="pill" href="#academic" role="tab" aria-controls="academic" aria-selected="false">
                            <i class="fas fa-graduation-cap"></i> Paramètres académiques
                        </a>
                        <a class="nav-link" id="notifications-tab" data-toggle="pill" href="#notifications" role="tab" aria-controls="notifications" aria-selected="false">
                            <i class="fas fa-bell"></i> Notifications
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">Paramètres</div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <div class="tab-content" id="v-pills-tabContent">
                        <!-- Paramètres Généraux -->
                        <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                            <h4>Paramètres généraux de l'établissement</h4>
                            <hr>
                            
                            <form action="{{ route('admin.settings.save.general') }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label for="school_name" class="col-sm-3 col-form-label">Nom de l'établissement</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('school_name') is-invalid @enderror" id="school_name" name="school_name" 
                                               value="{{ $generalSettings['school_name'] ?? old('school_name') }}">
                                        @error('school_name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="school_email" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control @error('school_email') is-invalid @enderror" id="school_email" name="school_email" 
                                               value="{{ $generalSettings['school_email'] ?? old('school_email') }}">
                                        @error('school_email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="school_phone" class="col-sm-3 col-form-label">Téléphone</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('school_phone') is-invalid @enderror" id="school_phone" name="school_phone" 
                                               value="{{ $generalSettings['school_phone'] ?? old('school_phone') }}">
                                        @error('school_phone')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="school_address" class="col-sm-3 col-form-label">Adresse</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control @error('school_address') is-invalid @enderror" id="school_address" name="school_address" 
                                                  rows="3">{{ $generalSettings['school_address'] ?? old('school_address') }}</textarea>
                                        @error('school_address')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="academic_year" class="col-sm-3 col-form-label">Année académique</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('academic_year') is-invalid @enderror" id="academic_year" name="academic_year" 
                                               value="{{ $generalSettings['academic_year'] ?? old('academic_year') }}" placeholder="Ex: 2024-2025">
                                        @error('academic_year')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                    </div>
                                </div>
                            </form>
                            
                            <hr>
                            <h5>Logo de l'établissement</h5>
                            
                            <form action="{{ route('admin.settings.upload.logo') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        @if(isset($generalSettings['school_logo']))
                                        <img src="{{ asset('images/logo1.png') }}" alt="lo" style="width: 100px; height: 100px; border-radius: 50%;">
                                        @endif
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input @error('school_logo') is-invalid @enderror" id="school_logo" name="school_logo">
                                            <label class="custom-file-label" for="school_logo">Choisir un fichier</label>
                                            @error('school_logo')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-primary mt-2">Télécharger</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Paramètres Académiques -->
                        <div class="tab-pane fade" id="academic" role="tabpanel" aria-labelledby="academic-tab">
                            <h4>Paramètres académiques</h4>
                            <hr>
                            
                            <form action="{{ route('admin.settings.save.academic') }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label for="passing_grade" class="col-sm-3 col-form-label">Note de passage</label>
                                    <div class="col-sm-9">
                                        <input type="number" step="0.01" min="0" max="20" class="form-control @error('passing_grade') is-invalid @enderror" 
                                               id="passing_grade" name="passing_grade" value="{{ $academicSettings['passing_grade'] ?? old('passing_grade') }}">
                                        @error('passing_grade')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="grading_system" class="col-sm-3 col-form-label">Système de notation</label>
                                    <div class="col-sm-9">
                                        <select class="form-control @error('grading_system') is-invalid @enderror" id="grading_system" name="grading_system">
                                            <option value="0-20" {{ isset($academicSettings['grading_system']) && $academicSettings['grading_system'] == '0-20' ? 'selected' : '' }}>
                                                0-20 (Français)
                                            </option>
                                            <option value="0-100" {{ isset($academicSettings['grading_system']) && $academicSettings['grading_system'] == '0-100' ? 'selected' : '' }}>
                                                0-100 (Pourcentage)
                                            </option>
                                            <option value="letter" {{ isset($academicSettings['grading_system']) && $academicSettings['grading_system'] == 'letter' ? 'selected' : '' }}>
                                                Lettres (A, B, C, D, F)
                                            </option>
                                        </select>
                                        @error('grading_system')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="semester_count" class="col-sm-3 col-form-label">Nombre de semestres</label>
                                    <div class="col-sm-9">
                                        <select class="form-control @error('semester_count') is-invalid @enderror" id="semester_count" name="semester_count">
                                            <option value="1" {{ isset($academicSettings['semester_count']) && $academicSettings['semester_count'] == '1' ? 'selected' : '' }}>
                                                1 (Année complète)
                                            </option>
                                            <option value="2" {{ isset($academicSettings['semester_count']) && $academicSettings['semester_count'] == '2' ? 'selected' : '' }}>
                                                2 (Semestres)
                                            </option>
                                            <option value="3" {{ isset($academicSettings['semester_count']) && $academicSettings['semester_count'] == '3' ? 'selected' : '' }}>
                                                3 (Trimestres)
                                            </option>
                                        </select>
                                        @error('semester_count')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Notifications -->
                        <div class="tab-pane fade" id="notifications" role="tabpanel" aria-labelledby="notifications-tab">
                            <h4>Paramètres de notification</h4>
                            <hr>
                            
                            <form action="{{ route('admin.settings.save.notifications') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="email_notifications" name="notifications[]" value="email"
                                               {{ isset($notificationSettings['email_notifications']) && $notificationSettings['email_notifications'] == '1' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="email_notifications">Activer les notifications par email</label>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="sms_notifications" name="notifications[]" value="sms"
                                               {{ isset($notificationSettings['sms_notifications']) && $notificationSettings['sms_notifications'] == '1' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="sms_notifications">Activer les notifications par SMS</label>
                                    </div>
                                </div>
                                
                                <hr>
                                <h5>Types d'alertes</h5>
                                
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="absence_alerts" name="notifications[]" value="absence"
                                               {{ isset($notificationSettings['absence_alerts']) && $notificationSettings['absence_alerts'] == '1' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="absence_alerts">Alertes d'absence</label>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="grade_alerts" name="notifications[]" value="grade"
                                               {{ isset($notificationSettings['grade_alerts']) && $notificationSettings['grade_alerts'] == '1' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="grade_alerts">Alertes de notes</label>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection