<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SkillTestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'skill_category' => 'required|string|max:100',
            'difficulty' => 'required|in:beginner,intermediate,advanced,expert',
            'duration_minutes' => 'required|integer|min:5|max:180',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.correct_answer' => 'required',
            'passing_score' => 'required|integer|min:0|max:100',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Please provide a test title.',
            'description.required' => 'Test description is required.',
            'skill_category.required' => 'Please specify the skill category.',
            'difficulty.required' => 'Please select a difficulty level.',
            'duration_minutes.required' => 'Please specify test duration.',
            'duration_minutes.min' => 'Test duration must be at least 5 minutes.',
            'duration_minutes.max' => 'Test duration cannot exceed 180 minutes.',
            'questions.required' => 'At least one question is required.',
            'passing_score.required' => 'Please set a passing score.',
        ];
    }
}
