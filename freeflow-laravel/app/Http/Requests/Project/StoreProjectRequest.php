<?php

namespace App\Http\Requests\Project;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'client_id' => ['nullable', 'integer', 'exists:clients,id'],
            'status' => ['sometimes', 'string', 'in:' . implode(',', [
                Project::STATUS_DRAFT,
                Project::STATUS_ACTIVE,
                Project::STATUS_ON_HOLD,
                Project::STATUS_COMPLETED,
                Project::STATUS_CANCELLED,
            ])],
            'priority' => ['sometimes', 'string', 'in:' . implode(',', [
                Project::PRIORITY_LOW,
                Project::PRIORITY_MEDIUM,
                Project::PRIORITY_HIGH,
                Project::PRIORITY_URGENT,
            ])],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'hourly_rate' => ['nullable', 'numeric', 'min:0'],
            'estimated_hours' => ['nullable', 'numeric', 'min:0'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['string', 'max:50'],
            'is_featured' => ['sometimes', 'boolean'],
            'is_public' => ['sometimes', 'boolean'],
            'notes' => ['nullable', 'string'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'status' => $this->input('status', Project::STATUS_DRAFT),
            'priority' => $this->input('priority', Project::PRIORITY_MEDIUM),
            'is_featured' => $this->boolean('is_featured'),
            'is_public' => $this->boolean('is_public'),
        ]);
    }
}