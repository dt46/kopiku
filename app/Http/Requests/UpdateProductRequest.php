<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'namaProduk' => 'required|string|max:255',
            'fotoProduk' => 'nullable',
            'nama_foto_original' => 'nullable',
            'hargaProduk' => 'required|integer|min:0',
            'stokProduk' => 'required|integer|min:0',
            'beratProduk' => 'required|integer|min:0',
            'deskripsiProduk' => 'required|string',
            'kategoriProduk' => 'required|string|max:255',
        ];
    }
}
