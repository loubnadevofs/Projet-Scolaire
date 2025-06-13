<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust based on your authorization logic
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'date_of_birth' => 'nullable|date',
            'class_id' => 'nullable|exists:school_classes,id',
            'registration_number' => 'required|unique:students,registration_number',
            'status' => 'in:active,inactive,graduated'
        ];
    }
}

class StudentUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust based on your authorization logic
    }

    public function rules()
    {
        $studentId = $this->route('student');

        return [
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:students,email,' . $studentId,
            'date_of_birth' => 'nullable|date',
            'class_id' => 'nullable|exists:school_classes,id',
            'registration_number' => 'sometimes|unique:students,registration_number,' . $studentId,
            'status' => 'in:active,inactive,graduated'
        ];
    }
}

