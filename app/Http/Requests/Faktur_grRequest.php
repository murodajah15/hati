<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Faktur_grRequest extends FormRequest
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
            'nofaktur' => [Rule::unique('faktur_gr')->ignore($this->faktur_gr)],
            'nopolisi' => ['required'],
        ];
    }
    public function messages()
    {
        return [
            'nofaktur.unique' => 'No.Faktur tidak boleh sama',
            'nopolisi.requires' => 'No.Polisi tidak boleh kosong',
        ];
    }
}
