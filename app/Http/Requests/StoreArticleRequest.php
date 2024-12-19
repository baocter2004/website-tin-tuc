<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreArticleRequest extends FormRequest
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
                'string',
                'max:100',
                Rule::unique('articles', 'title')
            ],
            'image' => 'nullable|image|max:2048',
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')
            ],
            'content' => 'required|string',
            'summary' => 'required|string',
            'tags' => 'required|array',
            'tags.*' => [
                'required',
                'integer',
                Rule::exists('tags', 'id')
            ],
            'new_tags' => 'nullable|array',
            'new_tags.*' => [
                'nullable',
                'string',
                'distinct',
                'max:100',
                Rule::unique('tags', 'name')
            ],
            'delete_reason' => [
                'required_if:status,deleted',
                'string',
                'nullable'
            ]
        ];
    }
}
