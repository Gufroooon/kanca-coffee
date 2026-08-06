<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:menu_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|url',
            'ingredients' => 'nullable|string',
            'calories' => 'nullable|integer|min:0',
            'is_available' => 'boolean',
            'is_bestseller' => 'boolean',
            'is_new' => 'boolean',
        ];
    }
}
