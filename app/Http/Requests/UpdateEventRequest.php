<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'start_time' => 'required|string',
            'end_time' => 'required|string',
            'location' => 'required|string',
            'capacity' => 'required|integer|min:1',
            'poster' => 'nullable|image|max:2048',
            'poster_url' => 'nullable|url',
            'price' => 'required|numeric|min:0',
            'speaker_name' => 'nullable|string',
            'speaker_title' => 'nullable|string',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
            'is_featured' => 'boolean',
        ];
    }
}
