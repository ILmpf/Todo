<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\TaskPriority;
use App\TaskStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'priority' => ['required', Rule::enum(TaskPriority::class)],
            'status' => ['required', Rule::enum(TaskStatus::class)],
            'due_date' => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'O título é obrigatório.',
            'title.max' => 'O título não pode ter mais de 255 caracteres.',
            'priority.required' => 'A prioridade é obrigatória.',
            'status.required' => 'O estado é obrigatório.',
        ];
    }
}
