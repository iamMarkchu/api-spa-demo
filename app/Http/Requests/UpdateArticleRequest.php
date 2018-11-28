<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateArticleRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'title' => [
                'required',
                'min:3',
                'max:255',
                Rule::unique('articles')->ignore($this->route('article')),
            ],
            //'title' => 'required|unique:articles|min:3|max:255',
            'content' => 'required',
            'order' => 'required|integer',
            'tags' => 'array',
            'categories' => 'array',
        ];
    }
}
