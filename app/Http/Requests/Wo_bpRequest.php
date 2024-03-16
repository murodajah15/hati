<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Wo_grRequest extends FormRequest
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
            'nowo' => [Rule::unique('wo_gr')->ignore($this->wo_gr)],
            'nopolisi' => ['required'],
        ];
    }
    public function messages()
    {
        return [
            'nowo.unique' => 'No.wo tidak boleh sama',
            'nopolisi.requires' => 'No.Polisi tidak boleh kosong',
        ];
    }
}
