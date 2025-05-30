<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
         $postId = $this->route('post'); 

        return [
            'title' => [
                'required',
                Rule::unique('posts', 'title')->ignore($postId),
            ],
            'body' => 'required',
            'image' => $this->isMethod('post') ? 'required' : 'nullable',
            'category_id' => 'required',
            'status' => 'nullable |in:0,1,2,3',
           'tags' => 'nullable|string',
        ];
    }
}
