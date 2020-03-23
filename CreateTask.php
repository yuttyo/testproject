<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTask extends FormRequest
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
            'title' => 'required|max:100',
            'due_data' => 'required|date|after_or_equal:today',
            //
        ];
    }

    public function attributes()
    {
        return[
            'title' => 'タイトル',
            'due_data' => '期限日',
        ];
    }

    public function messages()
    {
        return[
            'due_date.after_or_equal' =>':attribute には本日以降に日付を設定してください。'
        ];
    }
}
