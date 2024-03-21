<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Soh_bahanRequest extends FormRequest
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
        return [
            'noso' => ['required', Rule::unique('soh_bahan')->ignore($this->soh_bahan)],
            // 'noso' => ['required'],
            'tglso' => ['required'],
            'kdcustomer' => ['required'],
            'kdsales' => ['required'],
        ];
    }
    public function messages()
    {
        return [
            // 'noso.unique' => 'Nomor tidak boleh sama',
            'noso.required' => 'Nomor harus di isi',
            // 'tglso.required' => 'Tanggal harus di isi',
            // 'kdcustomer.required' => 'Customer harus di isi',
            // 'kdsales.required' => 'Sales harus di isi',
        ];
    }
}
