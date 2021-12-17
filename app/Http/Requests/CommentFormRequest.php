<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentFormRequest extends FormRequest
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
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'article_id.required'   => 'Не указан id статьи!',
            'article_id.integer'    => 'id должен быть числом!',
            'text.required'         => 'Сообщение должно быть заполнено!',
            'text.max'              => 'Сообщение должно содержать не более 255 символов!',
            'text.min'              => 'Слишком маленькое сообщение!'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'article_id'    => 'required|integer',
            'text'          => 'required|max:255|min:10'
        ];
    }
}
