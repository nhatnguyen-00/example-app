<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:255',
            'status' => 'required|integer',
            'author_id' => 'required|integer|exists:users,id',
            'tags' => 'required|array|min:1|max:8',
            'tags.*' => 'required|string|max:25',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'author_id' => auth()->id(),
        ]);
    }
}
