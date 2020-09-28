<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientStore extends FormRequest
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
            'name' => 'required',
            'app'=>'required',
            'cod' => 'required',
            'method_payment' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'app.required' => 'Selecione o Tipo de Aplicativo',
            'name.required' => 'Nome Obrigatório',
            'cod.required' => 'Código Obrigatório',
            'method_payment.required' => 'Metodo de Pagamento Obrigatório',
        ];
    }
}
