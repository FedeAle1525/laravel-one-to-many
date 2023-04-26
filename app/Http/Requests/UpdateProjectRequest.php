<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
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

            // Non basta solo la Validazione 'unique' perchè non permetterebbe di salvare lo stesso titolo non modificato
            'name' => [
                'required',
                'string',
                'max:150',
                // Indico quale sia il campo unico ed il valore da ignorare
                Rule::unique('projects', 'name')->ignore($this->project)
            ],
            'description' => 'nullable|string',
            'client' => 'required|string|max:100',
            'url' => 'nullable|url',
            // La FK 'type_id' deve combaciare con gli 'id' (PK) presenti nella Tabella 'Types'
            'type_id' => 'nullable|exists:types,id'
        ];
    }
}
