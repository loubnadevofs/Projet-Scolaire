<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit()
    {
        // منطق التعديل على الملف الشخصي
        return view('profile.edit');
    }
}
