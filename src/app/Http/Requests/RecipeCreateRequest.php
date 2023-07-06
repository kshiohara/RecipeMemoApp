<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecipeCreateRequest extends FormRequest
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
            'name' => 'required|max:100',
            'link' => 'nullable|max:2084',
            'rating' => 'nullable|integer|between:1,5',
            'status' => 'required|integer|between:1,2',
            'comment' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'name.required'   => 'レシピ名は必ず入力してください',
            'name.max'        => 'レシピ名は100文字以内で入力してください',
            'status.required' => '作成状況は必ず入力してください',
            'comment.required'   => 'レシピ名は必ず入力してください',
        ];
    }
}
