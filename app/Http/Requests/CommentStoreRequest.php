<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentStoreRequest extends FormRequest
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
            'parent_id' => 'nullable|integer',
            'author_id' => 'required|integer',
            'content' => 'required|string',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'author_id' => auth()->id(),
            'parent_id' => $this->request->get('parent_id') ?? 0
        ]);
    }
}
