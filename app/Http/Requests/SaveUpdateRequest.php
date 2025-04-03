<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveUpdateRequest extends FormRequest
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

        $bookId = $this->route('book')->id ?? null;

        return [
                'title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'isbn' => "required|string|max:13|unique:books,isbn,$bookId",
                'copies' => 'required|integer|max:255',
                'category_id' => 'required|exists:categories,id',
        ];
    }
}
