<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class FormPostRequest extends FormRequest
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
            'title' => ['required', 'min:4'],
            'content' => ['required', 'min:4'],
            'slug' => ['required', 'min:4', 'regex:/^[a-z0-9\-]+$/', Rule::unique('posts')->ignore($this->route()->parameter('post'))],
            'category_id' => ['required', 'exists:categories,id'],
            'tags' => ['required', 'array', 'exists:tags,id'],
            'image' => ['image', 'max:1000', Rule::requiredIf($this->route()->parameter('post') == null)]
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => $this->input('slug') ?: Str::slug($this->input('title'))
        ]);
    }
}
