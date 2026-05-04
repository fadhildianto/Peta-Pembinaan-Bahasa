<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Kegiatan;

class StorePesertaRequest extends FormRequest
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
        $kegiatanId = $this->input('kegiatan_id');
        $kegiatan = Kegiatan::find($kegiatanId);
        
        $rules = [
            'kegiatan_id' => 'required|exists:kegiatans,id',
        ];

        // Conditional rules berdasarkan jenis kegiatan
        if ($kegiatan) {
            if ($kegiatan->jenis_kegiatan === 'Penyuluhan Bahasa') {
                // Hanya nama dan instansi yang wajib
                $rules['nama'] = 'required|string|max:255';
                $rules['instansi'] = 'required|string|max:255';
                $rules['email'] = 'nullable|email|max:255';
                $rules['no_telp'] = 'nullable|string|max:20';
                $rules['alamat'] = 'nullable|string|max:500';
            } elseif ($kegiatan->jenis_kegiatan === 'Pembinaan Lembaga') {
                // Hanya instansi yang wajib (sebagai nama lembaga)
                $rules['nama'] = 'nullable|string|max:255';
                $rules['instansi'] = 'required|string|max:255';
                $rules['email'] = 'nullable|email|max:255';
                $rules['no_telp'] = 'nullable|string|max:20';
                $rules['alamat'] = 'nullable|string|max:500';
            }
        } else {
            // Default rules jika kegiatan tidak ditemukan
            $rules['nama'] = 'required|string|max:255';
            $rules['instansi'] = 'nullable|string|max:255';
            $rules['email'] = 'nullable|email|max:255';
            $rules['no_telp'] = 'nullable|string|max:20';
            $rules['alamat'] = 'nullable|string|max:500';
        }

        return $rules;
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
            'instansi.required' => 'Instansi/Lembaga harus diisi',
            'instansi.max' => 'Nama instansi maksimal 255 karakter',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Email maksimal 255 karakter',
            'no_telp.max' => 'No telepon maksimal 20 karakter',
            'alamat.max' => 'Alamat maksimal 500 karakter',
        ];
    }
}

