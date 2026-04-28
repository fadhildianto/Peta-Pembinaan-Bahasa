<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArsipRequest extends FormRequest
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
            'nama_file' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
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
            'nama_file.required' => 'Nama file harus diisi',
            'nama_file.max' => 'Nama file maksimal 255 karakter',
            'file.required' => 'File harus diunggah',
            'file.file' => 'File harus berupa file',
            'file.mimes' => 'File hanya bisa PDF, JPG, JPEG, PNG, DOC, atau DOCX',
            'file.max' => 'Ukuran file maksimal 10 MB',
        ];
    }
}
