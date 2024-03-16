<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Estimasi_grRequest extends FormRequest
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
            'noestimasi' => [Rule::unique('estimasi_gr')->ignore($this->estimasi_gr)],
            'nopolisi' => ['required'],
        ];
    }
    public function messages()
    {
        return [
            'noestimasi.unique' => 'No.Estimasi tidak boleh sama',
            'nopolisi.requires' => 'No.Polisi tidak boleh kosong',
        ];
    }
}
