<?php

namespace App\Http\Requests\VideoController;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RemoveOneRequest extends FormRequest
{

    public function authorize()
    {
        if (
           Auth::check() &&
            $video = request()->route('video')
        ) {
            return $video->isOwner;
        }

        return false;
    }

    public function rules()
    {
        return [
            //
        ];
    }
}
