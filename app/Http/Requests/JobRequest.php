<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isEmployer();
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
            'description' => 'required|string|min:50',
            'requirements' => 'nullable|string',
            'location' => 'required|string|max:255',
            'job_type' => 'required|string|in:full-time,part-time,contract,remote',
            'experience_level' => 'nullable|string|in:entry,mid,senior',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'skills_required' => 'nullable|array',
            'skills_required.*' => 'string',
            'expires_at' => 'nullable|date|after:today',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Please provide a job title.',
            'description.required' => 'Job description is required.',
            'description.min' => 'Job description must be at least 50 characters.',
            'location.required' => 'Please specify the job location.',
            'job_type.required' => 'Please select a job type.',
            'salary_max.gte' => 'Maximum salary must be greater than or equal to minimum salary.',
        ];
    }
}
