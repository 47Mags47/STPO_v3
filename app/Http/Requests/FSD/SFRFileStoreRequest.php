<?php

namespace App\Http\Requests\FSD;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class SFRFileStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'file' => ['required']
        ];
    }

    public function after():array
    {
        return [
            function(Validator $validator){
                $fileName = $validator->getValue('file')?->getClientOriginalName();

                if(!preg_match("/052[0-3][0-9][0-9]{2}[0-9]\.000/", $fileName))
                    $validator->errors()->add('file', 'Имя файла имеет недопустимый формат');
            }
        ];
    }
}
