<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    // Metodo che gestisce l'autorizzazione alla modifica dei dati
    public function authorize()
    {
        // Modifico in 'true' per avere permesso
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */

    // Metodo che gestisce le regole di 'Validazione'
    public function rules()
    {
        return [

            'name' => 'required|string|max:150|unique:projects,name',
            'description' => 'nullable|string',
            'client' => 'required|string|max:100',
            'url' => 'nullable|url'
        ];
    }
}
