<?php

namespace App\Http\Requests;

use App\Models\Article;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Support\Arr;


class ArticleFormRequest extends FormRequest
{

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $article = $this->route('article');

            if (Article::findBySlug($this->slug, $article ? $article->id : null)) {
                $validator->errors()->add('slug', 'Статья с таким символьным кодом уже существует!');
            }
            
        });
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function allCorrectFields()
    {
        return array_merge(
            Arr::where((array) $this->request->all(), function($v, $k){return in_array($k, ['_token', 'tags']) ? false : true;}),
            ['has_public' => $this->request->has('has_public') ? 1 : 0]
        );
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'         => '* заполните пустое поле!',
            'name.min'              => '* поле должно содержать не менее 5 символов!',
            'name.max'              => '* поле должно содержать не более 100 символов!',
            'preview.required'      => '* заполните пустое поле!',
            'preview.max'           => '* поле должно содержать не более 255 символов!',
            'slug.required'         => '* заполните пустое поле!',
            'slug.regex'            => '* поле должно содержать только из латинских символов, цифр, символов тире и подчеркивания формате: abv-123-a_3!',
            'description.required'  => '* заполните пустое поле!'
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
            'id'            => 'nullable|integer',
            'name'          => 'required|min:5|max:100',
            'preview'       => 'required|max:255',
            'slug'          => 'required|regex:/^[A-z0-9_]+(?:\-[A-z0-9_]+)*$/i',
            'description'   => 'required',
            'has_public'    => 'nullable'
        ];
    }
}
