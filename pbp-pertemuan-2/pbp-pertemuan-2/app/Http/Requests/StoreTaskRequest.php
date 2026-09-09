<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'      => ['required', 'string', 'min:3', 'max:200'],
            'project_id' => ['required', 'exists:projects,id'],
            'priority'   => ['required', 'in:low,medium,high'],
            'due_date'   => ['nullable', 'date', 'after_or_equal:today'],
        ];
    }
}