<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Comment;

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
        $validator = [
            'author_id' => 'required|integer',
            'content' => 'required|string',
        ];

        if ($this->parent_id === Comment::PARENT_COMMENT_DEFAULT) {
            $validator['parent_id'] = 'nullable|integer';
        } else {
            $validator['parent_id'] = 'nullable|integer|exists:comments,id';
        }

        return $validator;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'author_id' => auth()->id(),
            'parent_id' => $this->request->get('parent_id') ?? Comment::PARENT_COMMENT_DEFAULT
        ]);
    }
}
