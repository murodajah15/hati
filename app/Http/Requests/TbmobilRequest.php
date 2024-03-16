<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TbmobilRequest extends FormRequest
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
      'nopolisi' => ['required', Rule::unique('tbmobil')->ignore($this->tbmobil)],
      'norangka' => ['required'],
    ];
  }
  public function messages()
  {
    return [
      'nopolisi.unique' => 'No. Polisi tidak boleh sama',
      'nopolisi.required' => 'No. Polisi harus di isi',
      'norangka.required' => 'No. Rangka harus di isi',
    ];
  }
}
