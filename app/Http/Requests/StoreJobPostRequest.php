<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required','string','max:255'],
            'category_id' => ['required','exists:job_categories,id'],
            'description' => ['required','string'],
            'location' => ['nullable','string','max:255'],
            'salary_range' => ['nullable','string','max:255'],
            'work_type' => ['required','in:remote,onsite,hybrid'],
            'application_deadline' => ['required', 'date', 'after_or_equal:today'],
            'responsibilities' => ['required','string'],
            'skills' => ['required','string'],
            'requirements' => ['required','string'],
            'technologies' => ['nullable','string'],
            'benefits' => ['nullable','string'],
            'status' => ['nullable','in:pending,approved,rejected'],
        ];
    }
}
