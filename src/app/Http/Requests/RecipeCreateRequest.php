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
            'status' => 'integer',
            'comment' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'name.required'   => 'レシピ名：必ず入力してください。',
            'name.max'        => 'レシピ名：100文字以内で入力してください。',
            'status.integer' => '作成状況：「作成済み」、「未作成」のどちらかを選択してください。',
        ];
    }
}
