<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Kasir_tunaiRequest extends FormRequest
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
            // 'noso' => ['required', Rule::unique('soh')->ignore($this->soh)],
            'nokwitansi' => ['required'],
            'tglkwitansi' => ['required'],
            'nojual' => ['required'],
        ];
    }
    public function messages()
    {
        return [
            'nokwitansi.unique' => 'Nomor tidak boleh sama',
            'nokwitansi.required' => 'Nomor harus di isi',
            'tglkwitansi.required' => 'Tanggal harus di isi',
            'nojual.required' => 'Dokumen harus di isi',
        ];
    }
}
