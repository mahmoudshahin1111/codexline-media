<?php

namespace App\Http\Requests\VideoController;

use Illuminate\Foundation\Http\FormRequest;

class CreateOneRequest extends FormRequest
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
            'name'=>['required','string','max:100'],
            'video'=>['required','file','mimes:webm,flv,mp4,mov,ogg','max:20000']
        ];
    }
}
