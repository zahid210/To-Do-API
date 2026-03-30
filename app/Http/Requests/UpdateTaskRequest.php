<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

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
            'title'       => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'nullable|in:pending,in_progress,completed',
            'priority'    => 'nullable|in:low,medium,high',
            'due_date'    => 'nullable|date',
            'category_id' => 'nullable|exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'     => 'El título de la tarea es obligatorio.',
            'status.in'          => 'El estado debe ser: pending, in_progress o completed.',
            'priority.in'        => 'La prioridad debe ser: low, medium o high.',
            'category_id.exists' => 'La categoría seleccionada no existe.',
        ];
    }
}
