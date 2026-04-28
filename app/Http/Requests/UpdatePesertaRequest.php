<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePesertaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'kegiatan_id' => 'required|exists:kegiatans,id',
            'nama' => 'required|string|max:255',
            'instansi' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'no_telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'kegiatan_id.required' => 'Kegiatan harus dipilih',
            'kegiatan_id.exists' => 'Kegiatan tidak ditemukan',
            'nama.required' => 'Nama peserta harus diisi',
            'nama.max' => 'Nama peserta maksimal 255 karakter',
            'instansi.max' => 'Nama instansi maksimal 255 karakter',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Email maksimal 255 karakter',
            'no_telp.max' => 'No telepon maksimal 20 karakter',
            'alamat.max' => 'Alamat maksimal 500 karakter',
        ];
    }
}
