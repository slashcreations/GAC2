<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TarifCreateRequest extends FormRequest
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
            'libele'=>'required|string|max:50',
            'prix'=>'required|decimal',
            'annee-min'=>'required|date',
            'annee_max'=>'required|date',
            'annee_scolaire_id'=>'required|integer',
        ];
    }
}
